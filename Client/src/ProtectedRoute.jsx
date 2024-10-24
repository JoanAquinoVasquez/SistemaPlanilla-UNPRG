import { Navigate } from 'react-router-dom';
import PropTypes from 'prop-types';
import Cookies from 'js-cookie'; // Asegúrate de instalar js-cookie con npm install js-cookie

const ProtectedRoute = ({ children }) => {
  const token = Cookies.get('XSRF-TOKEN'); // Verifica si el token está en las cookies

  if (!token) {
    // Si no hay token, redirige al login
    return <Navigate to="/" />;
  }

  return children;
};

ProtectedRoute.propTypes = {
  children: PropTypes.node.isRequired,
};

export default ProtectedRoute;
``
