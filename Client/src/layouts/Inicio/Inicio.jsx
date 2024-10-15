import Breadcrumb from "../../components/Breadcrumb/Breadcrumb";
import { MdDashboard } from "react-icons/md";
import { MdSummarize } from "react-icons/md";
("use client");

import GraphicSummary from "./Graphics/GraphicSummary/GraphicSummary";
import GraphicDetail from "./Graphics/GraphicDetail/GraphicDetail";

function Inicio() {
  return (
    <div className=" ">
      <div>
        <Breadcrumb paths={[{ name: "Inicio", href: "/inicio" }]} />
      </div>
      <div className="bg-white rounded-lg p-4 shadow-md">
        <p className="flex items-center text-xl font-medium text-800">
          <MdDashboard className="mr-2" />
          Descripcción General
       
        </p>
        <div className="">
          <GraphicDetail /> 
        </div>
      </div>

      <div className="bg-white rounded-lg p-4 shadow-md mt-5">
        <p className="flex items-center text-xl font-medium text-800">
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
