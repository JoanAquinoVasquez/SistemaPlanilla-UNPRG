// routesSidebar.jsx
import { FaHome, FaUserTie, FaChartBar, FaUserGraduate, FaUserCog, FaUserAlt, FaGavel, FaWallet, FaCog, FaMinus } from 'react-icons/fa';

const routes = {
    menuItems: [
        { to: '/inicio', icon: <FaHome className="text-xl" />, text: 'Inicio' },
        { to: '/generar_planilla', icon: <FaChartBar className="text-xl" />, text: 'Generar Planilla' },
        { to: '/estadisticas', icon: <FaChartBar className="text-xl" />, text: 'Estadísticas' },
    ],
    personalItems: [
        { to: '/docentes', icon: <FaUserGraduate className="text-xl" />, text: 'Docentes', subLinks: [{ to: '/docentes/registrar', text: 'Registrar' }] },
        { to: '/administrativos', icon: <FaUserTie className="text-xl" />, text: 'Administrativos', subLinks: [{ to: '/administrativos/registrar', text: 'Registrar' }] },
        { to: '/pensionistas', icon: <FaUserAlt className="text-xl" />, text: 'Pensionistas', subLinks: [{ to: '/pensionistas/registrar', text: 'Registrar' }] },
        { to: '/practicantes', icon: <FaUserCog className="text-xl" />, text: 'Practicantes', subLinks: [{ to: '/practicantes/registrar', text: 'Registrar' }] },
        
    ],
    configItems: [
        { to: '/descuentos', icon: <FaMinus className="text-xl" />, text: 'Descuentos' },
        { to: '/leyes', icon: <FaGavel className="text-xl" />, text: 'Leyes' },
        { to: '/abonos', icon: <FaWallet className="text-xl" />, text: 'Abonos' },
        { to: '/ajustes', icon: <FaCog className="text-xl" />, text: 'Ajustes' },
    ]
};

export default routes;
