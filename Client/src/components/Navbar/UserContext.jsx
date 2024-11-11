import { createContext, useContext, useEffect, useState } from "react";
import axios from "axios";
import PropTypes from "prop-types";
import Cookies from "js-cookie";

// Crear el contexto
const UserContext = createContext(null);

// Custom hook para acceder al contexto
export const useUser = () => useContext(UserContext);

export const UserProvider = ({ children }) => {
  const [userData, setUserData] = useState(null);
  const userId = Cookies.get("userId");

  useEffect(() => {
    // Verificar si ya tenemos datos de usuario en sessionStorage
    const storedUserData = JSON.parse(sessionStorage.getItem("userData"));

    const fetchUserData = async () => {
      try {
        // Axios ya enviará las credenciales automáticamente
        const response = await axios.get(`/users/${userId}`);
        const fetchedUserData = response.data;

        // Guardar datos en el estado y en sessionStorage
        setUserData(fetchedUserData);
        sessionStorage.setItem("userData", JSON.stringify(fetchedUserData));
        Cookies.remove("userId");
      } catch (error) {
        console.error("Error fetching user data:", error);
      }
    };

    if (storedUserData) {
      setUserData(storedUserData);
    } else if (userId) {
      fetchUserData();
    }
  }, [userId]);

  return (
    <UserContext.Provider value={userData}>
      {children}
    </UserContext.Provider>
  );
};

UserProvider.propTypes = {
  children: PropTypes.node.isRequired,
};
