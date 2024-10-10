import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import './index.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Login from './layouts/Login/Login.jsx';
import { NextUIProvider } from "@nextui-org/react";

createRoot(document.getElementById('root')).render(
  <StrictMode>
    <NextUIProvider>
      <Router>
        <Routes>
          <Route path="/" element={<Login />} />
        </Routes>
      </Router>
    </NextUIProvider>
  </StrictMode>,
);
