import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import { handleLogout } from "./components/Logout/Logout";
import ModalSessionExpiration from "./components/SessionModal/SessionModal";

const SessionManager = ({ children }) => {
  const [isModalVisible, setIsModalVisible] = useState(false);
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [expiration, setExpiration] = useState(sessionStorage.getItem("expiration"));
  const navigate = useNavigate();

  useEffect(() => {
    if (expiration) {
      setIsAuthenticated(true);
      // console.log("Iniciando verificación de autenticación...");
      verifyAuth();
    } else {
      // console.log("No está autenticado, deteniendo verificación.");
    }
  }, [expiration]);

  const verifyAuth = async () => {
    if (!isAuthenticated) return;
    try {
      const response = await axios.get("/check-auth", { withCredentials: true });
      if (response.data.authenticated) {
        setIsAuthenticated(true);
        // console.log("Autenticación verificada y token válido");
      } else {
        // console.log("Token expirado o no autenticado.");
        setIsAuthenticated(false);
      }
    } catch (error) {
      // console.error("Error en la verificación de autenticación:", error);
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

    const warningTime = expiration - 2 * 60 * 1000;
    const autoLogoutTime = expiration - 30 * 1000;

    const checkSession = () => {
      const currentTime = new Date().getTime();

      if (currentTime >= warningTime && currentTime < expiration && !isModalVisible) {
        setIsModalVisible(true);
      }

      if (currentTime >= autoLogoutTime) {
        setIsModalVisible(false);
        setIsAuthenticated(false);
        handleLogout(navigate, "Su sesión ha caducado, por favor vuelva a iniciar sesión");
      }
    };

    const interval = setInterval(checkSession, 1000);
    return () => clearInterval(interval);
  }, [isAuthenticated, expiration, navigate, isModalVisible]);

  const handleKeepSession = async () => {
    try {
      const response = await axios.post("/refresh-token", {}, { withCredentials: true });
      const newExpiration = response.data.expiration * 1000;
      sessionStorage.setItem("expiration", newExpiration);
      setExpiration(newExpiration);
      setIsModalVisible(false);
      setIsAuthenticated(true);
    } catch (error) {
      console.error("Error al renovar el token:", error);
      setIsAuthenticated(false);
      handleLogout(navigate, "Su sesión ha caducado, por favor vuelva a iniciar sesión");
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
        />
      )}
      {children}
    </>
  );
};

export default SessionManager;
