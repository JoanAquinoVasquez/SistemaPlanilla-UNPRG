import { FaUser } from "react-icons/fa";
import { IoIosSearch } from "react-icons/io";
import {
  Dropdown,
  DropdownTrigger,
  DropdownMenu,
  DropdownItem,
  User,
} from "@nextui-org/react";

function Navbar() {
  return (
    <div className="bg-white pt-4 pb-2 pr-6 flex justify-end items-center relative" style={{background:"#fafafb", zIndex: "0"}}>
      <div className="flex items-center space-x-4">
        {/* Barra de búsqueda */}
        <div className="relative w-full md:w-96">
          <IoIosSearch className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
          <input
            type="text"
            placeholder="Buscar..."
            className="border pl-10 pr-5 py-1 border-gray-300 text-gray-900 text-sm rounded-lg w-full"
          />
        </div>

        {/* Iconos de notificaciones, carrito y usuario */}
        <div className="flex items-center ">
          <Dropdown placement="bottom-end">
            <DropdownTrigger>
              <User
                as="button"
                avatarProps={{
                  isBordered: true,
                  icon: <FaUser style={{ fontSize: "20px", color: "gray" }} />,
                  size: "sm",
                }}
                className="transition-transform"
                description="percycordova@unprg.com"
                name="Percy Córdova"
              />
            </DropdownTrigger>
            <DropdownMenu aria-label="Profile Actions" variant="flat">
              <DropdownItem key="logout" color="danger">
                Cerrar sesión
              </DropdownItem>
            </DropdownMenu>
          </Dropdown>
        </div>
      </div>
    </div>
  );
}

export default Navbar;
