import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import { handleLogout } from "./components/Logout/Logout";
import ModalSessionExpiration from "./components/SessionModal/SessionModal"; 

const SessionManager = ({ children }) => {
  const [isModalVisible, setIsModalVisible] = useState(false);
  const [tokenExpiration, setTokenExpiration] = useState(
    parseInt(sessionStorage.getItem("tokenExpiration"), 10) * 1000 || null
  );
  const navigate = useNavigate();

  useEffect(() => {
    const checkSession = () => {
      if (!tokenExpiration) return;

      const currentTime = new Date().getTime();
      const warningTime = tokenExpiration - 5 * 60 * 1000;

      if (currentTime >= warningTime && currentTime < tokenExpiration) {
        setIsModalVisible(true);
      }
    };

    const interval = setInterval(checkSession, 1000 * 60);
    return () => clearInterval(interval);
  }, [tokenExpiration]);

  const handleKeepSession = async () => {
    try {
      const response = await axios.post("/refresh-token");
      const newExpiration = response.data.expiration * 1000;

      sessionStorage.setItem("tokenExpiration", newExpiration);
      setTokenExpiration(newExpiration);
      setIsModalVisible(false);
    } catch (error) {
      console.error("Error al renovar el token:", error);
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
