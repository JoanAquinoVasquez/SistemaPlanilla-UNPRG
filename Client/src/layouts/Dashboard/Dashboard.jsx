// main.jsx
import { Routes, Route, useLocation } from "react-router-dom";
import Inicio from "../Inicio/Inicio";
import Practicantes from "../../pages/Practicantes/Practicantes";
import SidebarMenu from "../../components/Sidebar/Sidebar";
import Navbar from "../../components/Navbar/Navbar";
import LeyesParametros from "../../pages/Configuracion/Documentos";
import Notfound from "../../pages/NotFound/NotFound";
import "./Dashboard.css";
import { UserProvider } from "../../services/UserContext";

function Dashboard() {
  const location = useLocation();

  // Definimos las rutas de Dashboard dentro de un array
  const routes = [
    { path: "/inicio", element: <Inicio /> },
    { path: "/personal/practicante", element: <Practicantes /> },
    { path: "/configuracion/documentos", element: <LeyesParametros /> },
  ];

  // Extraemos los paths de las rutas definidas en el array anterior
  const validPaths = routes.map(route => route.path);
  const isNotFound = !validPaths.includes(location.pathname);

  return isNotFound ? (
    <Notfound /> // Muestra Notfound a pantalla completa
  ) : (
    <div className="flex">
      <SidebarMenu />
      <div className="divcant flex flex-col flex-1 ml-2">
        <UserProvider>
          <Navbar />
        </UserProvider>
        <div className="px-4 contenido-cambiante mb-3">
          <Routes>
            {routes.map((route, index) => (
              <Route key={index} path={route.path} element={route.element} />
            ))}
            <Route path="*" element={<Notfound />} /> {/* Página 404 interna */}
          </Routes>
        </div>
      </div>
    </div>
  );
}

export default Dashboard;
