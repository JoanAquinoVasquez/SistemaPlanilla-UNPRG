import topBarImage from "../../assets/Banners/barra_colores_ofic.jpg";
import logoWithTextImage from "../../assets/Banners/isotipo_variante_02.png";
import rightPanelImage from "../../assets/Banners/panelderechaImage.png";
import { useNavigate } from 'react-router-dom'; // Importa useNavigate
import { GOOGLE_CLIENT_ID } from '../../../config';


// Importa los componentes necesarios desde @react-oauth/google
import { GoogleOAuthProvider, GoogleLogin } from '@react-oauth/google';
import axios from 'axios';
import Cookies from 'js-cookie';


function Login() {
  const navigate = useNavigate(); // Usa el hook de navegación
  // Función para manejar el éxito del inicio de sesión
  const handleGoogleLoginSuccess = async (credentialResponse) => {
    const token = credentialResponse.credential;  // Token JWT de Google
    // console.log('Token JWT de Google:', token);

    // Enviar el token al backend (Laravel) para la validación
    try {
      const response = await axios.post('http://localhost:8000/api/google-login', {
        token
      });
      // console.log('Respuesta del backend:', response.data);
      // Aquí puedes manejar el token JWT que recibes del backend
      const jwtToken = response.data.token; // Suponiendo que tu backend devuelve el token JWT
      // Almacena el token JWT en cookies
      Cookies.set('jwtToken', jwtToken, { expires: 7 }); // Expira en 7 días
      // console.log('Cookie jwtToken:', Cookies.get('jwtToken')); // Verifica si la cookie se establece
      navigate('/inicio'); // Redirigir a la página deseada
    } catch (error) {
      console.error('Error al autenticar con el backend:', error);
    }
  };

  // Manejar errores en el inicio de sesión
  const handleGoogleLoginError = () => {
    console.log('Error en el inicio de sesión con Google');
  };

  return (
    <GoogleOAuthProvider clientId={GOOGLE_CLIENT_ID}>
      <div className="relative min-h-screen flex items-center justify-center bg-gray-100">
        <img
          src={topBarImage}
          alt="Barra de colores superior"
          className="absolute top-0 left-0 w-full h-3 object-cover"
        />

        <div className="grid grid-cols-1 lg:grid-cols-2 w-[79vw] h-[90vh] z-10">
          <div className="relative flex flex-col h-full bg-white px-10 rounded-lg shadow-lg">
            <div className="absolute top-0 left-0 right-0 flex items-center justify-between pt-4 px-10">
              <img
                src={logoWithTextImage}
                alt="UNPRG Logo"
                className="w-60 h-auto"
              />
              <div className="text-right">
                <h2 className="text-lg font-bold">Sistema de planillas v1.0</h2>
                <p className="text-sm">Periodo: 2024-I</p>
              </div>
            </div>

            <div className="flex flex-grow items-center justify-center">
              <div className="w-full">
                <h2 className="text-3xl font-bold text-center mb-10">LOG IN</h2>

                {/* Componente GoogleLogin */}
                <GoogleLogin
                  onSuccess={handleGoogleLoginSuccess}
                  onError={handleGoogleLoginError}
                />
              </div>
            </div>
          </div>

          <div className="relative bg-white ml-5 rounded-lg shadow-lg overflow-hidden">
            <img
              src={rightPanelImage}
              alt="Panel derecho"
              className="w-full h-full object-cover"
            />
            <div className="absolute top-0 left-0 w-full h-full bg-black opacity-30"></div>
          </div>
        </div>

        <img
          src={topBarImage}
          alt="Barra de colores inferior"
          className="absolute bottom-0 left-0 w-full h-3 object-cover"
        />
      </div>
    </GoogleOAuthProvider>
  );
}

export default Login;
