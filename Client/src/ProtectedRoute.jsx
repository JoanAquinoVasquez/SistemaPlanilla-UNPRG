import { useState, useEffect } from "react";
import { Navigate } from "react-router-dom";
import axios from "axios";
import Spinner from "./components/Spinner/Spinner.jsx"; // Importa el componente Spinner

const ProtectedRoute = ({ children }) => {
  const [isAuthenticated, setIsAuthenticated] = useState(null);

  useEffect(() => {
    axios
      .get("/check-auth") // La baseURL ya está configurada globalmente
      .then((response) => {
        setIsAuthenticated(response.data.authenticated);
      })
      .catch(() => {
        setIsAuthenticated(false);
      });
  }, []);

  if (isAuthenticated === null) {
    return <Spinner label="Cargando..."/>; 
  }

  if (!isAuthenticated) {
    return <Navigate to="/" />;
  }

  return children;
};

export default ProtectedRoute;
