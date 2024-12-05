import React from 'react';
import { Routes, Route, useLocation } from "react-router-dom";
import SidebarMenu from "../../components/Sidebar/Sidebar";
import Navbar from "../../components/Navbar/Navbar";
import Notfound from "../../pages/NotFound/NotFound";
import "./Dashboard.css";
import { UserProvider } from "../../services/UserContext";

function Dashboard() {
  const location = useLocation();

  // Definimos las rutas de Dashboard dentro de un array usando import() dinámico
  const routes = [
    { path: "/inicio", element: React.lazy(() => import("../Inicio/Inicio")) },
    { path: "/personal/practicante", element: React.lazy(() => import("../../pages/Practicantes/Practicantes")) },
    { path: "/configuracion/documentos", element: React.lazy(() => import("../../pages/Configuracion/Documentos")) },
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
              <Route
                key={index}
                path={route.path}
                element={
                  <React.Suspense fallback={<div>Loading...</div>}>
                    <route.element />
                  </React.Suspense>
                }
              />
            ))}
            <Route path="*" element={<Notfound />} /> {/* Página 404 interna */}
          </Routes>
        </div>
      </div>
    </div>
  );
}

export default Dashboard;
