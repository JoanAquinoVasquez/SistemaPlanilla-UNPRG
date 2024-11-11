// src/utils/logout.js
import Cookies from "js-cookie";
import axios from "axios";

export const handleLogout = (navigate) => {
  // Realiza la solicitud al backend para cerrar sesión
  axios
    .post("/logout", {}, { withCredentials: true })
    .then(() => {
      // Elimina cookies y sessionStorage
      Cookies.remove("token");
      sessionStorage.removeItem("userData");
      sessionStorage.removeItem("tokenExpiration");

      // Redirige al usuario a la página de inicio de sesión
      navigate("/");
    })
    .catch((error) => {
      console.error("Error al cerrar sesión:", error);
    });
};
