import "./Login.css";
import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { FaEye, FaEyeSlash } from "react-icons/fa";
import barraImage from "../../assets/Banners/barra_colores_ofic.jpg";
import logoconnombreImage from "../../assets/Banners/isotipo_variante_02.png";
import Image from "../../assets/Banners/Image.png";

function Login() {
  const [usuario, setUsuario] = useState("");
  const [password, setPassword] = useState("");
  const [showPassword, setShowPassword] = useState(false);
  const navigate = useNavigate();

  const handleLogin = async (e) => {
    e.preventDefault();

    if (usuario === "admin" && password === "123") {
      localStorage.setItem("usuario", usuario);
      navigate("/Inicio");
    } else {
      alert("Usuario o contraseña incorrectos");
    }
  };

  const renderInputField = (
    type,
    value,
    setValue,
    placeholder,
    label,
    showToggle = false
  ) => (
    <div className="relative mb-4 input-container">
      <input
        type={type}
        value={value}
        onChange={(e) => setValue(e.target.value)}
        className="w-full px-4 py-2 border border-gray-300 rounded-lg input-field focus:outline-none focus:border-gray-300 focus:ring-gray-300"
        placeholder={placeholder}
        autoComplete="current-password"
      />
      <label
        className={`input-label absolute left-4 transition-all pointer-events-none pt-1.5 ${
          value ? "-top-0" : "top-0"
        }`}
      >
        {label}
      </label>
      {showToggle && (
        <div
          className="absolute transform -translate-y-1/2 cursor-pointer right-4 top-1/2"
          onClick={() => setShowPassword(!showPassword)}
        >
          {showPassword ? <FaEyeSlash /> : <FaEye />}
        </div>
      )}
    </div>
  );

  return (
    <div className="relative min-h-screen flex items-center justify-center bg-gray-100">
      {/* Barra superior */}
      <img
        src={barraImage}
        alt="Barra de colores superior"
        className="absolute top-0 left-0 w-full h-3 object-cover"
      />

      {/* Contenedor principal que usa grid para dividir la pantalla */}
      <div className="grid grid-cols-1 lg:grid-cols-2 w-[80vw] h-[90vh] shadow-lg rounded-lg overflow-hidden z-10">
        {/* Panel izquierdo (formulario de login) */}
        <div className=" flex-col min-h-screen px-10 pt-8 bg-white ">
          {/* Banner superior */}
          <div className="banner-login-ingo flex items-start justify-between mb-6">
            <img
              src={logoconnombreImage}
              alt="Logo UNPRG"
              className="w-[15rem] h-auto"
            />
            <div className="text-right">
              <h2 className="text-xl font-bold">Sistema de planillas v1.0</h2>
              <p className="text-sm">Periodo: 2024-I</p>
            </div>
          </div>

          {/* Formulario centrado */}
          <div className="formulario flex-col justify-center pt-20 mt-20">
            <h2 className="text-3xl font-bold text-center mb-10">LOGIN</h2>

            {renderInputField(
              "text",
              usuario,
              setUsuario,
              "example.email@gmail.com",
              "Email"
            )}
            {renderInputField(
              showPassword ? "text" : "password",
              password,
              setPassword,
              "*******",
              "Password",
              true
            )}

            <p className="text-end text-blue-500 mb-4">
              Si se olvidó su contraseña comuníquese con soporte
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

        {/* Panel derecho (imagen de la universidad) */}
        <div className="hidden lg:block bg-white ml-5">
          <img
            src={Image}
            alt="Universidad Nacional Pedro Ruiz Gallo"
            className="w-full h-full object-cover p-0 m-0"
          />
        </div>
      </div>

      {/* Barra inferior */}
      <img
        src={barraImage}
        alt="Barra de colores inferior"
        className="absolute bottom-0 left-0 w-full h-3 object-cover"
      />
    </div>
  );
}

export default Login;
