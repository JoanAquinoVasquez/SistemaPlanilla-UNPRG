import useTipoEmpleado from "../../data/dataTipoEmpleado";
import { HomeIcon } from "../Icons/HomeIcon";
import { MinusIcon } from "../Icons/MinusIcon";
import { WalletIcon } from "../Icons/WalletIcon";
import { UserPersonIcon } from "../Icons/UserPersonIcon";
import { ChartBarIcon } from "../Icons/ChartBarIcon";
import { UserCogIcon } from "../Icons/UserCogIcon";
import { CogIcon } from "../Icons/CogIcon";
import { FlowParallelIcon } from "../Icons/FlowParallelIcon";
import { CalendarSharpIcon } from "../Icons/CalendarSharpIcon";
import { DocumentTextSharpIcon } from "../Icons/DocumentTextSharpIcon";

const useRoutes = () => {
  const tipoempleados = useTipoEmpleado();

  // Definir los elementos del menú y personalizarlos
  const menuItems = [
    { to: "/inicio", icon: <HomeIcon className="text-xl" />, text: "Inicio" },
    {
      to: "/generar_planilla",
      icon: <ChartBarIcon className="text-xl" />,
      text: "Generar Planilla",
    },
  ];

  const personalItems = [
    {
      to: "/personal",
      icon: <UserPersonIcon className="text-xl" />,
      text: "Personal",
      subLinks: tipoempleados.map((empleado) => ({
        to: `/personal/${empleado.label.toLowerCase()}`,
        text: empleado.label,
      })),
    },
    {
      to: "/familiares",
      icon: <UserCogIcon className="text-xl" />,
      text: "Datos Familiares",
    },
    {
      to: "/control_asistencias",
      icon: <CalendarSharpIcon className="text-xl" />,
      text: "Control de Asistencias",
    },
  ];

  const configItems = [
    {
      to: "/descuentos",
      icon: <MinusIcon className="text-xl" />,
      text: "Descuentos",
    },
    {
      to: "/ingresos",
      icon: <WalletIcon className="text-xl" />,
      text: "Ingresos",
    },
    {
      to: "/configuracion/documentos",
      icon: <DocumentTextSharpIcon className="text-xl" />,
      text: "Documentos",
    },
    {
      to: "/configuracion/parametros",
      icon: <FlowParallelIcon className="text-xl" />,
      text: "Parametros",
    },
    { to: "/ajustes", icon: <CogIcon className="text-xl" />, text: "Ajustes" },
  ];

  // Puedes usar `import()` dinámico aquí si es necesario para otros recursos más pesados
  const loadIcon = async (iconName) => {
    const { default: IconComponent } = await import(`../Icons/${iconName}.jsx`); // Asegúrate de incluir la extensión del archivo
    return IconComponent;
  };

  

  return {
    menuItems,
    personalItems,
    configItems,
    loadIcon,
  };
};

export default useRoutes;
