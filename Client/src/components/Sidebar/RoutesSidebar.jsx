// routesSidebar.jsx
import {
  FaHome,
  FaChartBar,
  FaUserGraduate,
  FaUserCog,
  FaGavel,
  FaWallet,
  FaCog,
  FaMinus,
} from "react-icons/fa";
import { IoCalendarSharp } from "react-icons/io5";
import "./Sidebar"

const routes = {
  menuItems: [
    {
      to: "/inicio",
      icon: <FaHome className="text-xl" />,
      text: "Inicio",
    },
    {
      to: "/generar_planilla",
      icon: <FaChartBar className="text-xl" />,
      text: "Generar Planilla",
    },
  ],
  personalItems: [
    {
      to: "/personal",
      icon: <FaUserGraduate className="text-xl" />,
      text: "Personal",
      subLinks: [
        { to: "/personal/docente", text: "Docentes" },
        { to: "/personal/administrativos", text: "Administrativos" },
        { to: "/personal/pensionistas", text: "Pensionistas" },
        { to: "/personal/practicantes", text: "Practicantes" },
      ],
    },
    {
      to: "/familiares",
      icon: <FaUserCog className="text-xl" />,
      text: "Datos Familiares",
    },
    {
      to: "/control_asistencias",
      icon: <IoCalendarSharp className="text-xl" />,
      text: "Control de Asistencias",
      className: "truncate",
    },
  ],
  configItems: [
    {
      to: "/descuentos",
      icon: <FaMinus className="text-xl" />,
      text: "Descuentos",
    },
    { to: "/configuracion/leyesparametros", icon: <FaGavel className="text-xl" />, text: "Leyes / Parametros" },
    { to: "/ingresos", icon: <FaWallet className="text-xl" />, text: "Ingresos" },
    { to: "/ajustes", icon: <FaCog className="text-xl" />, text: "Ajustes" },
  ],
};

export default routes;
