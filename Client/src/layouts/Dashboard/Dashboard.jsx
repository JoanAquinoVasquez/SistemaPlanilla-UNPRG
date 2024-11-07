import { Routes, Route } from "react-router-dom";
import Inicio from "../Inicio/Inicio";
import Practicantes from "../../pages/Practicantes/Practicantes";
import SidebarMenu from "../../components/Sidebar/Sidebar";
import Navbar from "../../components/Navbar/Navbar";
import LeyesParametros from "../../pages/Configuracion/LeyesParametros";
import "./Dashboard.css";
import { UserProvider } from "./../../components/Navbar/UserContext";

function Dashboard() {
  return (
    <div className="flex">
      <SidebarMenu />
      {/* Contenido de la página */}
      <div className="divcant flex flex-col flex-1 ml-2">
        <UserProvider>
          {/* Componente Navbar que contiene la barra de navegación superior */}
          <Navbar />
        </UserProvider>
        <div className="px-4 contenido-cambiante mb-3">
          <Routes>
            <Route path="/inicio" element={<Inicio />} />
            <Route path="/personal/practicantes" element={<Practicantes />} />
            <Route path="/configuracion/leyesparametros" element={<LeyesParametros />} />
          </Routes>
        </div>
      </div>
    </div>
  );
}

export default Dashboard;
