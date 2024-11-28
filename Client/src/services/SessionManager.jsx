import React, { useEffect, useState, useRef } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import { handleLogout } from "./Logout/Logout";
import ModalSessionExpiration from "../components/Modal/Session/SessionModal";

const SessionManager = ({ children }) => {
  const navigate = useNavigate();

  // Tiempos de control
  const INACTIVITY_LIMIT = 15 * 60 * 1000; // 15 minutos
  const WARNING_TIME_BEFORE_EXPIRATION = 4 * 60 * 1000; // 4 minutos antes de expiración
  const AUTO_LOGOUT_TIME_BEFORE_EXPIRATION = 1 * 60 * 1000; // 1 minuto antes de expiración
  const INACTIVITY_MODAL_CLOSE_TIME = 3 * 60 * 1000; // 3 minutos para responder al modal

  const [isModalVisible, setIsModalVisible] = useState(false);
  const [modalType, setModalType] = useState(""); // Tipo de modal ("expiracion" o "inactividad")
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [expiration, setExpiration] = useState(
    parseInt(sessionStorage.getItem("expiration"), 10)
  );
  const [inactivityCounter, setInactivityCounter] = useState(INACTIVITY_LIMIT / 1000); // Contador de inactividad en segundos
  const [modalResponseCounter, setModalResponseCounter] = useState(INACTIVITY_MODAL_CLOSE_TIME / 1000); // Contador para responder al modal en segundos

  // Refs para los temporizadores
  const inactivityTimeoutRef = useRef(null);
  const inactivityCounterIntervalRef = useRef(null);
  const inactivityModalTimeoutRef = useRef(null);
  const expirationIntervalRef = useRef(null);

  // Función para reiniciar el temporizador de inactividad
  const resetInactivityTimeout = () => {
    setInactivityCounter(INACTIVITY_LIMIT / 1000); // Reinicia el contador de inactividad
    if (inactivityTimeoutRef.current) clearTimeout(inactivityTimeoutRef.current);
    if (inactivityCounterIntervalRef.current) clearInterval(inactivityCounterIntervalRef.current);

    // Inicia el intervalo del contador de inactividad
    inactivityCounterIntervalRef.current = setInterval(() => {
      setInactivityCounter((prev) => {
        if (prev > 0) return prev - 1;
        clearInterval(inactivityCounterIntervalRef.current);
        return 0;
      });
    }, 1000);

    // Configura el tiempo límite de inactividad
    inactivityTimeoutRef.current = setTimeout(() => {
      setModalType("inactividad");
      setIsModalVisible(true);
      setModalResponseCounter(INACTIVITY_MODAL_CLOSE_TIME / 1000);

      // Temporizador de cierre automático del modal si no se responde
      inactivityModalTimeoutRef.current = setTimeout(() => {
        setIsModalVisible(false);
        setIsAuthenticated(false);
        handleLogout(
          navigate,
          "Su sesión ha caducado debido a inactividad, por favor vuelva a iniciar sesión"
        );
      }, INACTIVITY_MODAL_CLOSE_TIME);
    }, INACTIVITY_LIMIT);
  };

  // Configura el chequeo de expiración y reinicia el intervalo
  const setupExpirationCheck = () => {
    if (expirationIntervalRef.current) clearInterval(expirationIntervalRef.current);

    expirationIntervalRef.current = setInterval(() => {
      const currentTime = new Date().getTime();
      const warningTime = expiration - WARNING_TIME_BEFORE_EXPIRATION;
      const autoLogoutTime = expiration - AUTO_LOGOUT_TIME_BEFORE_EXPIRATION;

      if (currentTime >= warningTime && currentTime < expiration && (!isModalVisible || modalType === "inactividad")) {
        setModalType("expiracion");
        setIsModalVisible(true);
        clearTimeout(inactivityModalTimeoutRef.current);
      }

      if (currentTime >= autoLogoutTime) {
        setIsModalVisible(false);
        setIsAuthenticated(false);
        handleLogout(
          navigate,
          "Su sesión ha caducado, por favor vuelva a iniciar sesión"
        );
      }
    }, 1000);
  };

  // Función para cerrar el modal y reiniciar el temporizador de inactividad
  const handleModalClose = () => {
    setIsModalVisible(false);
    clearTimeout(inactivityModalTimeoutRef.current);

    // Reinicia el temporizador de inactividad después de cerrar el modal
    resetInactivityTimeout(); // Asegura que el contador se reinicie y vuelva a mostrarse al llegar a 0
  };

  // Escucha eventos de usuario para detectar actividad
  useEffect(() => {
    const events = ["mousemove", "keydown", "click"];
    events.forEach((event) =>
      window.addEventListener(event, resetInactivityTimeout)
    );

    return () => {
      events.forEach((event) =>
        window.removeEventListener(event, resetInactivityTimeout)
      );
      clearTimeout(inactivityTimeoutRef.current);
      clearTimeout(inactivityModalTimeoutRef.current);
      clearInterval(expirationIntervalRef.current);
      clearInterval(inactivityCounterIntervalRef.current);
    };
  }, []);

  useEffect(() => {
    if (expiration) {
      setIsAuthenticated(true);
      verifyAuth();
    }
  }, [expiration]);

  useEffect(() => {
    if (isAuthenticated && expiration) {
      resetInactivityTimeout();
      setupExpirationCheck();
    }
    return () => clearInterval(expirationIntervalRef.current);
  }, [isAuthenticated, expiration]);

  const verifyAuth = async () => {
    if (!isAuthenticated) return;
    try {
      const response = await axios.get("/check-auth", { withCredentials: true });
      setIsAuthenticated(response.data.authenticated);
    } catch (error) {
      setIsAuthenticated(false);
    }
  };

  // Función para manejar la renovación del token
  const handleKeepSession = async () => {
    try {
      const response = await axios.post("/refresh-token", {}, { withCredentials: true });
      const newExpiration = response.data.expiration * 1000;
      sessionStorage.setItem("expiration", newExpiration);
      setExpiration(newExpiration);
      setIsAuthenticated(true);
      setIsModalVisible(false);

      clearTimeout(inactivityTimeoutRef.current);
      clearTimeout(inactivityModalTimeoutRef.current);
      resetInactivityTimeout();
      setupExpirationCheck();
    } catch (error) {
      setIsAuthenticated(false);
      handleLogout(
        navigate,
        "Su sesión ha caducado, por favor vuelva a iniciar sesión"
      );
    }
  };

  return (
    <>
      {isModalVisible && (
        <ModalSessionExpiration
          isOpen={isModalVisible}
          onClose={handleModalClose} // Reinicia el temporizador al cerrar el modal
          onKeepSession={handleKeepSession}
          onLogout={() => handleLogout(navigate)}
          type={modalType}
        />
      )}
      {children}
    </>
  );
};

export default SessionManager;
