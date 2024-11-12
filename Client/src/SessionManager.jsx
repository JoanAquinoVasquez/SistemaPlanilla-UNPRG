import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import { handleLogout } from "./components/Logout/Logout";
import ModalSessionExpiration from "./components/SessionModal/SessionModal";

const SessionManager = ({ children }) => {
  const [isModalVisible, setIsModalVisible] = useState(false);
  const [modalType, setModalType] = useState(""); // Tipo de modal ("expiracion" o "inactividad")
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [expiration, setExpiration] = useState(
    sessionStorage.getItem("expiration")
  );
  const navigate = useNavigate();

  // Tiempo de inactividad y otros tiempos de control
  const INACTIVITY_LIMIT = 15 * 60 * 1000; // 15 minutos
  const WARNING_TIME_BEFORE_EXPIRATION = 3 * 60 * 1000; // 3 minutos antes de expiración
  const AUTO_LOGOUT_TIME_BEFORE_EXPIRATION = 1 * 60 * 1000; // 1 minuto antes de expiración
  const INACTIVITY_MODAL_CLOSE_TIME = 2 * 60 * 1000; // 2 minutos para responder al modal
  let inactivityTimeout;
  let inactivityModalTimeout; // Tiempo para cierre automático en modal de inactividad

  // Función para reiniciar el temporizador de inactividad
  const resetInactivityTimeout = () => {
    if (inactivityTimeout) clearTimeout(inactivityTimeout);
    inactivityTimeout = setTimeout(() => {
      // Solo mostrar el modal de inactividad si el modal de expiración no está activo
      if (!isModalVisible) {
        setModalType("inactividad");
        setIsModalVisible(true);

        // Iniciar temporizador para cierre automático en caso de inactividad
        inactivityModalTimeout = setTimeout(() => {
          setIsModalVisible(false);
          setIsAuthenticated(false);
          handleLogout(
            navigate,
            "Su sesión ha caducado debido a inactividad, por favor vuelva a iniciar sesión"
          );
        }, INACTIVITY_MODAL_CLOSE_TIME);
      }
    }, INACTIVITY_LIMIT);
  };

  // Escucha eventos de usuario para detectar actividad
  useEffect(() => {
    const events = ["mousemove", "keydown", "click"];
    events.forEach((event) =>
      window.addEventListener(event, resetInactivityTimeout)
    );

    // Limpiar eventos y temporizadores al desmontar
    return () => {
      events.forEach((event) =>
        window.removeEventListener(event, resetInactivityTimeout)
      );
      clearTimeout(inactivityTimeout);
      clearTimeout(inactivityModalTimeout); // Limpia el temporizador de cierre automático del modal
    };
  }, []);

  useEffect(() => {
    if (expiration) {
      setIsAuthenticated(true);
      verifyAuth();
    }
  }, [expiration]);

  const verifyAuth = async () => {
    if (!isAuthenticated) return;
    try {
      const response = await axios.get("/check-auth", {
        withCredentials: true,
      });
      if (response.data.authenticated) {
        setIsAuthenticated(true);
      } else {
        setIsAuthenticated(false);
      }
    } catch (error) {
      setIsAuthenticated(false);
    }
  };

  useEffect(() => {
    const interval = setInterval(() => {
      if (isAuthenticated) {
        verifyAuth();
      } else {
        clearInterval(interval);
      }
    }, 1 * 60 * 1000); // Verificación cada minuto

    return () => clearInterval(interval);
  }, [isAuthenticated]);

  // Control de expiración y advertencia
  useEffect(() => {
    if (!isAuthenticated || !expiration) return;

    const warningTime = expiration - WARNING_TIME_BEFORE_EXPIRATION;
    const autoLogoutTime = expiration - AUTO_LOGOUT_TIME_BEFORE_EXPIRATION;

    const checkSession = () => {
      const currentTime = new Date().getTime();

      // Muestra el modal de expiración del token y desactiva el de inactividad
      if (
        currentTime >= warningTime &&
        currentTime < expiration &&
        (!isModalVisible || modalType === "inactividad") // Prioriza la expiración sobre inactividad
      ) {
        setModalType("expiracion");
        setIsModalVisible(true);
        clearTimeout(inactivityModalTimeout); // Desactiva el temporizador de inactividad
      }

      // Cierra la sesión automáticamente 30 segundos antes de la expiración del token
      if (currentTime >= autoLogoutTime) {
        setIsModalVisible(false);
        setIsAuthenticated(false);
        handleLogout(
          navigate,
          "Su sesión ha caducado, por favor vuelva a iniciar sesión"
        );
      }
    };

    const interval = setInterval(checkSession, 1000);
    return () => clearInterval(interval);
  }, [isAuthenticated, expiration, navigate, isModalVisible, modalType]);

  // Función para manejar la renovación del token
  const handleKeepSession = async () => {
    try {
      const response = await axios.post(
        "/refresh-token",
        {},
        { withCredentials: true }
      );
      const newExpiration = response.data.expiration * 1000;
      sessionStorage.setItem("expiration", newExpiration);
      setExpiration(newExpiration);
      setIsModalVisible(false);
      setIsAuthenticated(true);
      resetInactivityTimeout(); // Reinicia el temporizador de inactividad
      clearTimeout(inactivityModalTimeout); // Cancela el temporizador de cierre automático
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
          onClose={() => setIsModalVisible(false)}
          onKeepSession={handleKeepSession}
          onLogout={() => handleLogout(navigate)}
          type={modalType} // Pasa el tipo de modal
        />
      )}
      {children}
    </>
  );
};

export default SessionManager;
