import { useUser } from "./UserContext";
import { FaUser } from "react-icons/fa";
import { handleLogout } from "../Logout/Logout";
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
import { useNavigate } from "react-router-dom";
import Spinner from "../Spinner/Spinner"; // Importa el componente Spinner

function Navbar() {
  const userData = useUser();
  const navigate = useNavigate();

  if (!userData) return <Spinner label="Cargando..."/>; 

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
            <DropdownItem key="logout" color="danger" onClick={() => handleLogout(navigate,"Sesión cerrada correctamente")}>
              Cerrar sesión
            </DropdownItem>
          </DropdownMenu>
        </Dropdown>
      </div>
    </div>
  );
}

export default Navbar;
