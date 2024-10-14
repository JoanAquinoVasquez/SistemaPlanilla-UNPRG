import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import './index.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Login from './layouts/Login/Login.jsx';
import Dashboard from './layouts/Dashboard/Dashboard';

import { NextUIProvider } from "@nextui-org/react";

createRoot(document.getElementById('root')).render(
  <StrictMode>
    <NextUIProvider>
      <Router>
        <Routes>
          <Route path="/" element={<Login />} />
          <Route>
            <Route path="/*" element={<Dashboard />} />
          </Route>
        </Routes>
      </Router>
    </NextUIProvider>
  </StrictMode>,
);
