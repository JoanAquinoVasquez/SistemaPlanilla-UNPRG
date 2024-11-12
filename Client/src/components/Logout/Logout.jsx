import axios from "axios";

export const handleLogout = (navigate, message = "") => {
  // Realiza la solicitud al backend para cerrar sesión
  axios
    .post("/logout", {}, { withCredentials: true })
    .then(() => {
      // Elimina cookies y sessionStorage
      sessionStorage.removeItem("userData");
      sessionStorage.removeItem("tokenExpiration");
      sessionStorage.removeItem("expiration"); 

      // Redirige al usuario a la página de inicio de sesión
      if (message) {
        navigate("/", { state: { logoutMessage: message } });
      } else {
        navigate("/"); // Sin mensaje si es cierre de sesión manual
      }
    })
    .catch((error) => {
      console.error("Error al cerrar sesión:", error);
    });
};
