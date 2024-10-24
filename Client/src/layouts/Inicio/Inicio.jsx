import Breadcrumb from "../../components/Breadcrumb/Breadcrumb";
import { MdDashboard } from "react-icons/md";
import { MdSummarize } from "react-icons/md";
("use client");

import GraphicSummary from "./Graphics/GraphicSummary/GraphicSummary";
import GraphicDetail from "./Graphics/GraphicDetail/GraphicDetail";

function Inicio() {
  return (
<div className=" "> {/* Añadí container y padding */}
  <div>
    <Breadcrumb paths={[{ name: "Inicio", href: "/inicio" }]} />
  </div>
  <div className="bg-white rounded-lg p-3 shadow-md mb-3"> {/* Añadí margen inferior */}
    <p className="flex items-center text-xl font-medium text-gray-800">
      <MdDashboard className="mr-2" />
      Descripción General
    </p>
    <div className="mt-4">
      <GraphicDetail />
    </div>
  </div>
  <div className="bg-white rounded-lg p-3 shadow-md mt-3">
    <p className="flex items-center text-xl font-medium text-gray-800">
      <MdSummarize className="mr-2" />
      Resumen Gráfico
    </p>
    <div className="mt-4">
      <GraphicSummary />
    </div>
  </div>
</div>

  );
}

export default Inicio;