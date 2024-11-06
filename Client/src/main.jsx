import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import "./index.css";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./layouts/Login/Login.jsx";
import Dashboard from "./layouts/Dashboard/Dashboard";
import ProtectedRoute from "./ProtectedRoute.jsx";
import { NextUIProvider } from "@nextui-org/react";
import axios from 'axios';

// Configuración global para Axios
axios.defaults.baseURL = 'http://localhost:8000/api';
axios.defaults.withCredentials = true; // Permitir que las cookies se incluyan automáticamente


createRoot(document.getElementById("root")).render(
  <StrictMode>
    <NextUIProvider>
      <Router>
        <Routes>
          <Route path="/" element={<Login />} />
          <Route
            path="/*"
            element={
              <ProtectedRoute>
                  <Dashboard />
              </ProtectedRoute>
            }
          />
        </Routes>
      </Router>
    </NextUIProvider>
  </StrictMode>
);