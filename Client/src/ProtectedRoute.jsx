import { Navigate } from 'react-router-dom';
import PropTypes from 'prop-types';
import Cookies from 'js-cookie'; // Asegúrate de instalar js-cookie con npm install js-cookie

const ProtectedRoute = ({ children }) => {
  // Verifica si el token JWT está en las cookies
  const token = Cookies.get('jwtToken'); // Asegúrate de que el nombre coincida con el que usaste para guardar el token

  if (!token) {
    // Si no hay token, redirige al login
    return <Navigate to="/" />;
  }

  // Si hay token, muestra los hijos (el contenido de la ruta protegida)
  return children;
};

ProtectedRoute.propTypes = {
  children: PropTypes.node.isRequired,
};

export default ProtectedRoute;
