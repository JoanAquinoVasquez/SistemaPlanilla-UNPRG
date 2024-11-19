import { useState, useEffect } from "react";
import { useNavigate, useLocation } from "react-router-dom";
import topBarImage from "../../assets/Barra/barra_colores_ofic.jpg";
import logoWithTextImage from "../../assets/Isotipos/isotipo_variante_02.png";
import rightPanelImage from "../../assets/Img/panelderechaImage.png";
import { GoogleOAuthProvider, GoogleLogin } from "@react-oauth/google";
import axios from "axios";
import Cookies from "js-cookie";

function Login() {
  const navigate = useNavigate();
  const location = useLocation();
  const [errorMessage, setErrorMessage] = useState("");
  const [logoutMessage, setLogoutMessage] = useState("");

  useEffect(() => {
    if (location.state && location.state.logoutMessage) {
      setLogoutMessage(location.state.logoutMessage);
    }
  }, [location]);

  const handleGoogleLoginSuccess = async (credentialResponse) => {
    const token = credentialResponse.credential;

    try {
      const response = await axios.post("/google-login", { token });
      const userId = response.data.user_id;
      const expiration = response.data.expiration * 1000;
      Cookies.set("userId", userId, { expires: 7 });
      sessionStorage.setItem("expiration", expiration);

      navigate("/inicio");
    } catch (error) {
      setErrorMessage(
        error.response ? error.response.data.error : "Error al autenticar con el backend."
      );
      console.error("Error al autenticar con el backend:", error);
    }
  };

  const handleGoogleLoginError = () => {
    setErrorMessage("Error al iniciar sesión con Google.");
  };

  return (
    <GoogleOAuthProvider clientId={import.meta.env.VITE_GOOGLE_CLIENT_ID}>
      <div className="relative min-h-screen flex items-center justify-center bg-gray-100">
        <img src={topBarImage} alt="Barra de colores superior" className="absolute top-0 left-0 w-full h-3 object-cover" />
        <div className="grid grid-cols-1 lg:grid-cols-2 w-[79vw] h-[90vh] z-10">
          <div className="relative flex flex-col h-full bg-white px-10 rounded-lg shadow-lg">
            <div className="absolute top-0 left-0 right-0 flex items-center justify-between pt-4 px-10">
              <img src={logoWithTextImage} alt="UNPRG Logo" className="w-60 h-auto" />
              <div className="text-right">
                <h2 className="text-lg font-bold">Sistema de planillas v1.0</h2>
                <p className="text-sm">Periodo: 2024-I</p>
              </div>
            </div>

            <div className="flex flex-grow items-center justify-center">
              <div className="w-full">
                <h2 className="text-3xl font-bold text-center mb-10">LOG IN</h2>

                {logoutMessage && <div className="mb-4 text-red-500 text-center">{logoutMessage}</div>}
                {errorMessage && <div className="mb-4 text-red-500 text-center">{errorMessage}</div>}

                <GoogleLogin onSuccess={handleGoogleLoginSuccess} onError={handleGoogleLoginError} />
              </div>
            </div>
          </div>
          <div className="relative bg-white ml-5 rounded-lg shadow-lg overflow-hidden hidden lg:block">
            <img src={rightPanelImage} alt="Panel derecho" className="w-full h-full object-cover" />
            <div className="absolute top-0 left-0 w-full h-full bg-black opacity-30"></div>
          </div>
        </div>
        <img src={topBarImage} alt="Barra de colores inferior" className="absolute bottom-0 left-0 w-full h-3 object-cover" />
      </div>
    </GoogleOAuthProvider>
  );
}

export default Login;
