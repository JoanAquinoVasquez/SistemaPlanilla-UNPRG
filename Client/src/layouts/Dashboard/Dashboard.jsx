import { Routes, Route } from 'react-router-dom';
import Inicio from '../Inicio/Inicio';
import Practicantes from '../../pages/Practicantes/Practicantes';
import SidebarMenu from '../../components/Sidebar/Sidebar';
import Navbar from '../../components/Navbar/Navbar';
import './Dashboard.css';

function Dashboard() {
    return (
        <div className="flex" >
            {/* Componente Sidebar que contiene el menú de navegación */}
            <SidebarMenu />
            {/* Contenido de la página */}
            <div className="divcant flex flex-col flex-1 ml-2"  >
                {/* Componente Navbar que contiene la barra de navegación superior */}
                < Navbar /> 
                <div className="px-4 contenido-cambiante mb-3"  >
                    <Routes>
                        <Route path="/inicio" element={<Inicio />} />
                        <Route path="/practicantes" element={<Practicantes />} />
                    </Routes>
                </div>
            </div>
        </div>
    );
}

export default Dashboard;
