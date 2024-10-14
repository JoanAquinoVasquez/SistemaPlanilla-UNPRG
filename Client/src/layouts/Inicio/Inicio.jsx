import Breadcrumb from "../../components/Breadcrumb/Breadcrumb";
import { MdDashboard } from "react-icons/md";
import { MdSummarize  } from "react-icons/md";

function Inicio() {
  return (
    <div className=" ">
      <div>
        <Breadcrumb paths={[{ name: "Inicio", href: "/inicio" }]} />
      </div>
      <div className="bg-white rounded-lg p-4 shadow-md">
        <p className="flex items-center text-xl font-medium text-800">
          <MdDashboard className="mr-2"/>
          Descripcción General
        </p>
      </div>

      <div className="bg-white rounded-lg p-4 shadow-md mt-8">
        <p className="flex items-center text-xl font-medium text-800">
          <MdSummarize  className="mr-2"/>
          Resumen Gráfico
        </p>
      </div>
    </div>
  );
}

export default Inicio;
