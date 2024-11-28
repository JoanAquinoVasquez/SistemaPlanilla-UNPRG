import { useUser } from "../../services/UserContext";
import { handleLogout } from "../../services/Logout/Logout";
import { Dropdown, DropdownTrigger, DropdownMenu, DropdownItem, User, Badge, Button } from "@nextui-org/react";
import { NotificationIcon } from "../../components/Icons/NotificationIcon";
import { useNavigate } from "react-router-dom";
import Spinner from "../Spinner/Spinner";

function Navbar() {
  const userData = useUser();
  const navigate = useNavigate();

  if (!userData) return <Spinner label="Cargando..." />;

  const { profile_picture, email, name } = userData;

  return (
    <div className="bg-white pt-4 pb-2 pr-2 flex justify-end items-center relative" style={{ background: "#fafafb", zIndex: 0 }}>
      <div className="flex items-center mr-5">
        <div className="mr-5">
          <Badge content="3" shape="circle" color="danger">
            <Button radius="full" isIconOnly aria-label="more than 99 notifications" variant="light">
              <NotificationIcon size={24} />
            </Button>
          </Badge>
        </div>

        <Dropdown placement="bottom-end">
          <DropdownTrigger>
            <User
              as="button"
              avatarProps={{ isBordered: true, size: "sm", src: profile_picture || null }}
              className="transition-transform"
              description={email || "Error: Email"}
              name={name || "Error: Name"}
            />
          </DropdownTrigger>
          <DropdownMenu aria-label="Profile Actions" variant="flat">
            <DropdownItem key="logout" color="danger" onClick={() => handleLogout(navigate, "Sesión cerrada correctamente")}>
              Cerrar sesión
            </DropdownItem>
          </DropdownMenu>
        </Dropdown>
      </div>
    </div>
  );
}

export default Navbar;
