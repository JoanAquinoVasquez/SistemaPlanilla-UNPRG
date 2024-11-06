import { GoogleOAuthProvider, GoogleLogin } from "@react-oauth/google";
import axios from "axios";
import Cookies from "js-cookie"; // Asegúrate de instalar js-cookie
import { useHistory } from "react-router-dom"; // Agrega esta línea
import { GOOGLE_CLIENT_ID } from "../../../config";

const Login = () => {
  const history = useHistory(); // Usar el hook de historia
  // Maneja el éxito del login con Google
  const handleLoginSuccess = async (credentialResponse) => {
    const token = credentialResponse.credential; // Captura el token JWT de Google

    // Enviar el token al backend para su validación o creación de sesión
    try {
      const response = await axios.post("/google-login", {
        token, // Envía el token al backend
      });

      // console.log('Respuesta del backend:', response.data);
      const jwtToken = response.data.token; // Suponiendo que tu backend devuelve el token JWT

      // Almacena el token JWT en cookies
      Cookies.set("jwtToken", jwtToken, { expires: 7 }); // Expira en 7 días
      // console.log('Cookie jwtToken:', Cookies.get('jwtToken')); // Verifica si la cookie se establece
      history.push("/inicio"); // Redirigir a la página deseada
      // Aquí puedes manejar la redirección o el estado de la aplicación
    } catch (error) {
      console.error("Error al enviar el token al backend:", error);
    }
  };

  // Maneja errores en el inicio de sesión
  const handleLoginError = (error) => {
    console.error("Error en el login:", error);
  };

  return (
    <GoogleOAuthProvider clientId={GOOGLE_CLIENT_ID}>
      <div>
        <h1>Iniciar sesión con Google</h1>
        <GoogleLogin
          onSuccess={handleLoginSuccess}
          onError={handleLoginError}
        />
      </div>
    </GoogleOAuthProvider>
  );
};

export default Login;
