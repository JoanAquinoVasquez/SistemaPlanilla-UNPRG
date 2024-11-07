// useRoutes.js
import { FaHome, FaChartBar, FaUserGraduate, FaUserCog, FaWallet, FaCog, FaMinus } from "react-icons/fa";
import { IoCalendarSharp, IoDocumentTextSharp  } from "react-icons/io5";
import useTipoEmpleado from "../../Data/DataTipoEmpleado";
import { TiFlowParallel } from "react-icons/ti";

const useRoutes = () => {
  const tipoempleados = useTipoEmpleado();
  return {
    menuItems: [
      { to: "/inicio", icon: <FaHome className="text-xl" />, text: "Inicio" },
      { to: "/generar_planilla", icon: <FaChartBar className="text-xl" />, text: "Generar Planilla" },
    ],
    personalItems: [
      {
        to: "/personal",
        icon: <FaUserGraduate className="text-xl" />,
        text: "Personal",
        subLinks: tipoempleados.map((empleado) => ({
          to: `/personal/${empleado.label.toLowerCase()}`,
          text: empleado.label,
        })),
      },
      { to: "/familiares", icon: <FaUserCog className="text-xl" />, text: "Datos Familiares" },
      { to: "/control_asistencias", icon: <IoCalendarSharp className="text-xl" />, text: "Control de Asistencias" },
    ],
    configItems: [
      { to: "/descuentos", icon: <FaMinus className="text-xl" />, text: "Descuentos" },
      { to: "/ingresos", icon: <FaWallet className="text-xl" />, text: "Ingresos" },

      { to: "/configuracion/documentos", icon: <IoDocumentTextSharp  className="text-xl" />, text: "Documentos" },
      { to: "/configuracion/parametros", icon: <TiFlowParallel   className="text-xl" />, text: "Parametros" },
      { to: "/ajustes", icon: <FaCog className="text-xl" />, text: "Ajustes" },
    ],
  };
};

export default useRoutes;
