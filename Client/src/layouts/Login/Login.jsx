import { useNavigate } from "react-router-dom";
import topBarImage from "../../assets/Banners/barra_colores_ofic.jpg";
import logoWithTextImage from "../../assets/Banners/isotipo_variante_02.png";
import rightPanelImage from "../../assets/Banners/panelderechaImage.png";

function Login() {
  const navigate = useNavigate();

  const handleGoogleLogin = () => {
    // Redirige a la ruta de Laravel para autenticarse con Google
    window.open("http://localhost:8000/google-auth/redirect", "_self");
  };

  return (
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

              {/* Botón para iniciar sesión con Google */}
              <button
                onClick={handleGoogleLogin}
                className="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg"
              >
                Iniciar Sesión con Google
              </button>
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
  );
}

export default Login;
