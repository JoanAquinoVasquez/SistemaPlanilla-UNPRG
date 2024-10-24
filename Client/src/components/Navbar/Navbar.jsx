import { useEffect, useState } from "react";
import { FaUser } from "react-icons/fa";
import { IoIosSearch } from "react-icons/io";

import {
  Dropdown,
  DropdownTrigger,
  DropdownMenu,
  DropdownItem,
  User,
  Badge,
  Button,
} from "@nextui-org/react";
import { NotificationIcon } from "../../components/Icons.jsx/NotificationIcon";
import axios from "axios";
import Cookies from "js-cookie";

function Navbar() {
  const [userData, setUserData] = useState({
    name: "",
    email: "",
    profile_picture: "",
  });

  const token = Cookies.get("jwtToken");

  // Verificar si los datos ya están en localStorage
  const storedUserData = JSON.parse(localStorage.getItem("userData"));

  useEffect(() => {
    const fetchUserData = async () => {
      // Solo hace la petición si los datos no están en localStorage
      if (!storedUserData) {
        try {
          const userId = 2; // Obtén este ID dinámicamente si es necesario
          const response = await axios.get(
            `http://localhost:8000/api/users/${userId}`,
            {
              headers: {
                Authorization: `Bearer ${token}`,
              },
            }
          );

          const userData = {
            name: response.data.name,
            email: response.data.email,
            profile_picture: response.data.profile_picture,
          };

          // Guardar los datos del usuario en el estado y en localStorage
          setUserData(userData);
          localStorage.setItem("userData", JSON.stringify(userData));
        } catch (error) {
          console.error(error);
        }
      } else {
        // Si ya están en localStorage, los usamos directamente
        setUserData(storedUserData);
      }
    };

    fetchUserData();
  }, [token, storedUserData]);

  return (
    <div
      className="bg-white pt-4 pb-2 pr-6 flex justify-end items-center relative"
      style={{ background: "#fafafb", zIndex: "0" }}
    >
        <div className="relative w-full md:w-96">
          <IoIosSearch className="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
          <input
            type="text"
            placeholder="Buscar..."
            className="border pl-10 pr-5 py-1 border-gray-300 text-gray-900 text-sm rounded-lg w-full"
          />
        </div>

        <div className="flex items-center">
          <div className="mr-5">
            <Badge content="3" shape="circle" color="danger">
              <Button
                radius="full"
                isIconOnly
                aria-label="more than 99 notifications"
                variant="light"
              >
                <NotificationIcon size={24} />
              </Button>
            </Badge>
          </div>

          <Dropdown placement="bottom-end">
            <DropdownTrigger>
              <User
                as="button"
                avatarProps={{
                  isBordered: true,
                  icon: <FaUser style={{ fontSize: "20px", color: "gray" }} />,
                  size: "sm",
                  src: userData.profile_picture || null,
                }}
                className="transition-transform"
                description={userData.email ? userData.email : "Error: Email"}
                name={userData.name ? userData.name : "Error: Name"}
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
      
  );
}

export default Navbar;
