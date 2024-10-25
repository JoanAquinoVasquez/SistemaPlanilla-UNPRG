import { useUser } from "./UserContext";
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

function Navbar() {
  const userData = useUser();
  if (!userData) return <div>Cargando...</div>;
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