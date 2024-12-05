// resources/js/main.jsx
import React from 'react';
import ReactDOM from 'react-dom/client'; // Asegúrate de usar createRoot para React 18
import { StrictMode } from "react";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Login from "./layouts/Login/Login.jsx";
import Dashboard from "./layouts/Dashboard/Dashboard";
import ProtectedRoute from "./services/ProtectedRoute.jsx";
import { NextUIProvider } from "@nextui-org/react";
import SessionManager from "./services/SessionManager.jsx";
import axios from "axios";

// Configuración global para Axios
axios.defaults.baseURL = "/api";
axios.defaults.withCredentials = true;

const rootElement = document.getElementById("root");
if (rootElement) {
  const root = ReactDOM.createRoot(rootElement);
  root.render(
    <StrictMode>
      <NextUIProvider>
        <BrowserRouter>
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
}
