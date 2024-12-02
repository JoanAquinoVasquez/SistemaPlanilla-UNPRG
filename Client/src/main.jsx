import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import "./index.css";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Login from "./layouts/Login/Login.jsx";
import Dashboard from "./layouts/Dashboard/Dashboard";
import ProtectedRoute from "./services/ProtectedRoute.jsx";
import { NextUIProvider } from "@nextui-org/react";
import SessionManager from "./services/SessionManager.jsx";
import axios from "axios";

// Configuración global para Axios
axios.defaults.baseURL = "http://localhost:8000/api";
// axios.defaults.baseURL = "http://localhost:8000/api";
axios.defaults.withCredentials = true; // Permitir que las cookies se incluyan automáticamente

createRoot(document.getElementById("root")).render(
  <StrictMode>
    <NextUIProvider>
      <BrowserRouter
        basename="/client/"
        future={{ v7_startTransition: true, v7_relativeSplatPath: true }} 
        //v7_startTransition Este flag habilita la nueva forma de transiciones de navegación introducida en React Router v7.
        //v7_relativeSplatPath Este flag cambia cómo React Router v7 manejará las rutas con el comodín *
      >
        <Routes>
          <Route path="/" element={<Login />} />
          <Route
            path="/*"
            element={
              <SessionManager>
                <ProtectedRoute>
                  <Dashboard />
                </ProtectedRoute>
              </SessionManager>
            }
          />
        </Routes>
      </BrowserRouter>
    </NextUIProvider>
  </StrictMode>
);
