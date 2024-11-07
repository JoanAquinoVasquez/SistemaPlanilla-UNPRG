import { useState } from 'react';
import { FaCaretDown, FaCaretUp } from 'react-icons/fa';
import { Link } from '@nextui-org/react';
import imgcollapsed from '../../assets/Isotipos/isotipo_variante_02.png';
import './sidebar.css';
import routes from './routesSidebar.jsx';

const SidebarMenu = () => {
    const [expandedLinks, setExpandedLinks] = useState({});

    const toggleLink = (link) => {
        setExpandedLinks((prevState) => ({
            ...prevState,
            [link]: !prevState[link],
        }));
    };

    const renderMenuItems = (items) => (
        items.map(({ to, icon, text, subLinks }) => (
            <div key={to}>
                <li className="li-sidebar flex items-center pl-6 px-4 w-full">
                    <Link href={to} className="flex items-center w-full hover-effect " style={{color: "#747474"}}>
                        {icon}
                        <span className="ml-4 text-ellipsis overflow-hidden whitespace-nowrap">{text}</span>
                    </Link>
                    {subLinks && (
                        <button onClick={() => toggleLink(to)} className="ml-auto" style={{color: "#747474"}}>
                            {expandedLinks[to] ? <FaCaretUp /> : <FaCaretDown />}
                        </button>
                    )}
                </li>
                {expandedLinks[to] && subLinks && (
                    <ul className="ml-10">
                        {subLinks.map((subLink) => (
                            <li key={subLink.to} className='li-sidebar'>
                                <Link href={subLink.to} className="flex items-center w-full px-2 pl-4 hover-effect" style={{color: "#747474"}}>
                                    <span>{subLink.text}</span>
                                </Link>
                            </li>
                        ))}
                    </ul>
                )}
            </div>
        ))
    );

    return (
        <div className="sidebar shadow-lg flex flex-col w-60" style={{background:"#ffffff"}}>
            <div className="flex items-center p-4">
                <img src={imgcollapsed} alt="Logo" className="w-100 h-13" />
            </div>
            
            <div className="px-6">
                <h2 className="text-md font-semibold">Sistema de planillas v1.0</h2>
                <p className="text-sm text-gray-600">Periodo: 2024-I</p>
            </div>

            <nav className="flex-1 mt-4 overflow-y-auto">
                <ul className="space-y-1.5 px-3">
                    {renderMenuItems(routes.menuItems)}

                    <div className="px-4 text-gray-500 font-semibold">Empleados</div>
                    <hr className="mx-6"/>
                    {renderMenuItems(routes.personalItems)}

                    <div className="px-4 text-gray-500 font-semibold">Configuración</div>
                    <hr className="mx-4"/>
                    {renderMenuItems(routes.configItems)}
                </ul>
            </nav>

            
        </div>

        
    );
};

export default SidebarMenu;
