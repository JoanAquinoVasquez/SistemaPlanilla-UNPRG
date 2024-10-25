import { createContext, useContext, useEffect, useState } from "react";
import axios from "axios";
import Cookies from "js-cookie";

// Crear el contexto
const UserContext = createContext(null);

export const useUser = () => useContext(UserContext);

export const UserProvider = ({ children }) => {
  const [userData, setUserData] = useState(null);
  const token = Cookies.get("jwtToken");
  const userId = Cookies.get("userId");

  useEffect(() => {
    const storedUserData = JSON.parse(sessionStorage.getItem("userData"));

    const fetchUserData = async () => {
      try {
        const response = await axios.get(`http://localhost:8000/api/users/${userId}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        const fetchedUserData = response.data;

        setUserData(fetchedUserData);
        sessionStorage.setItem("userData", JSON.stringify(fetchedUserData));
      } catch (error) {
        console.error("Error fetching user data:", error);
      }
    };

    if (storedUserData) {
      setUserData(storedUserData);
    } else if (token && userId) {
      fetchUserData();
    }
  }, [token, userId]);

  return (
    <UserContext.Provider value={userData}>
      {children}
    </UserContext.Provider>
  );
};
