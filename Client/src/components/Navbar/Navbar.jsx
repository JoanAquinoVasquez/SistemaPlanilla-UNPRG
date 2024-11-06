import { useUser } from "./UserContext";
import { FaUser } from "react-icons/fa";
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
import Cookies from "js-cookie";
import { useNavigate } from "react-router-dom";
import axios from "axios";

function Navbar() {
  const userData = useUser();
  const navigate = useNavigate();

  if (!userData) return <div>Cargando...</div>;

  const handleLogout = () => {
    // Hacer una solicitud de cierre de sesión al backend
    axios
      .post("/logout", {}, { withCredentials: true })
      .then(() => {
        // Elimina las cookies de sesión y limpia los datos de usuario
        Cookies.remove("userId");
        Cookies.remove("token"); // Elimina la cookie principal también
        sessionStorage.removeItem("userData");
        // Actualizar el estado global a no autenticado
        navigate("/"); // Redirige al usuario a la página de inicio de sesión o de inicio
      })
      .catch((error) => {
        console.error("Error al cerrar sesión:", error);
      });
  };

  return (
    <div
      className="bg-white pt-4 pb-2 pr-6 flex justify-end items-center relative"
      style={{ background: "#fafafb", zIndex: "0" }}
    >
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
            <DropdownItem key="logout" color="danger" onClick={handleLogout}>
              Cerrar sesión
            </DropdownItem>
          </DropdownMenu>
        </Dropdown>
      </div>
    </div>
  );
}

export default Navbar;
