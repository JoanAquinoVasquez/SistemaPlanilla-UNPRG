import { useState } from "react";
import { useNavigate } from "react-router-dom";
import InputField from "../../components/InputField";
import topBarImage from "../../assets/Banners/barra_colores_ofic.jpg";
import logoWithTextImage from "../../assets/Banners/isotipo_variante_02.png";
import rightPanelImage from "../../assets/Banners/panelderechaImage.png";

function Login() {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  const [showPassword, setShowPassword] = useState(false);
  const navigate = useNavigate();

  const handleLogin = (e) => {
    e.preventDefault();
    if (username === "admin" && password === "123") {
      localStorage.setItem("username", username);
      navigate("/Inicio");
    } else {
      alert("Usuario o contraseña incorrectos");
    }
  };

  const togglePasswordVisibility = () => setShowPassword(!showPassword);

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

              <InputField
                divContainerStyle="relative mb-4"
                type="text"
                value={username}
                setValue={setUsername}
                placeholder="example.email@gmail.com"
                classNameInputField="w-full px-4 py-2 pt-7 border border-gray-300 rounded-lg bg-gray-100/60 focus:outline-none"
                label="Correo institucional"
                classNameLabel="absolute left-4 transition-all pointer-events-none font-bold pt-1.5"
              />
              <InputField
                divContainerStyle="relative mb-4"
                type={showPassword ? "text" : "password"}
                value={password}
                setValue={setPassword}
                placeholder="*******"
                label="Contraseña"
                showToggle
                showPassword={showPassword}
                classNameInputField="w-full px-4 py-2 pt-7 border border-gray-300 rounded-lg bg-gray-100/60 focus:outline-none"
                classNameLabel="absolute left-4 transition-all pointer-events-none font-bold pt-1.5"
                togglePasswordVisibility={togglePasswordVisibility}
                classNameShowToggle="absolute transform -translate-y-1/2 cursor-pointer right-4 top-1/2"
              />

              <p className="text-end text-blue-700 text-sm mb-4">
                Si olvidó su contraseña, comuníquese con soporte
              </p>

              <button
                type="submit"
                onClick={handleLogin}
                className="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg"
              >
                Iniciar Sesión
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
