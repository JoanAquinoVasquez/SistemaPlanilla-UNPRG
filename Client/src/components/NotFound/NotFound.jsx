import { Link } from 'react-router-dom';
import topBarImage from "../../assets/Barra/barra_colores_ofic.jpg";
import logounprg from "../../assets/Isotipos/isotipo_variante_03.png";

const NotFound = () => {
    return (
        <div className="flex flex-col items-center justify-center min-h-screen text-center bg-gray-100 relative">
            {/* Barra superior */}
            <img
                src={topBarImage}
                alt="Barra de colores superior"
                className="absolute top-0 left-0 w-full h-5 object-cover"
            />
            
            <div className="flex flex-col sm:flex-row sm:justify-between sm:w-full sm:max-w-screen-lg items-center sm:space-x-8 space-y-6 sm:space-y-0">
                {/* Logo */}
                <div className="w-full sm:w-auto">
                    <img
                        src={logounprg}
                        alt="Logo UNPRG"
                        className="w-80 object-contain mx-auto sm:mx-0"
                    />
                </div>

                {/* 404 Text */}
                <div className="text-center">
                    <h1 className="text-9xl font-extrabold text-gray-800">404 :(</h1>
                    <p className="text-3xl text-gray-600 mb-6 mt-4">Oops! La página que buscas no existe.</p>
                    <Link 
                        to="/inicio" 
                        className="text-3xl text-blue-600 hover:text-blue-800 transition duration-300 ease-in-out"
                    >
                        Volver al inicio
                    </Link>
                </div>
            </div>

            {/* Barra inferior */}
            <img
                src={topBarImage}
                alt="Barra de colores inferior"
                className="absolute bottom-0 left-0 w-full h-5 object-cover"
            />
        </div>
    );
};

export default NotFound;
