import {
  Modal,
  ModalContent,
  ModalHeader,
  ModalBody,
  ModalFooter,
  Button,
} from "@nextui-org/react";
import PropTypes from "prop-types";

export default function ModalSessionExpiration({
  isOpen,
  onClose,
  onKeepSession,
  onLogout,
  type,
}) {
  const isInactivityWarning = type === "inactividad";
  const title = isInactivityWarning
    ? "Inactividad Detectada"
    : "Sesión a punto de Expirar";
  const message = isInactivityWarning
    ? "Ha estado inactivo durante un tiempo. ¿Desea mantener su sesión o cerrar sesión?"
    : "Su sesión está a punto de expirar. ¿Desea mantener su sesión o cerrar sesión?";

  return (
    <Modal
      backdrop="opaque"
      isOpen={isOpen}
      onOpenChange={onClose}
      placement="top-center"
      size="lg"
    >
      <ModalContent>
        {(closeModal) => (
          <>
            <ModalHeader className="flex flex-col gap-1">{title}</ModalHeader>

            <ModalBody>
              <p className="text-center text-lg">
                {type === "inactividad"
                  ? "¿Desea mantener su sesión activa?"
                  : "Su sesión está a punto de expirar. ¿Desea mantener su sesión o cerrar sesión?"}
              </p>
            </ModalBody>

            <ModalFooter>
              {/* Solo muestra el botón de "Cerrar Sesión" si el tipo es "expiración" */}
              {type === "expiracion" && (
                <Button
                  color="danger"
                  variant="flat"
                  onPress={() => {
                    onLogout(); // Llama a onLogout, que contiene la función `handleLogout`
                    closeModal();
                  }}
                >
                  Cerrar Sesión
                </Button>
              )}
              <Button
                color="primary"
                onPress={() => {
                  onKeepSession();
                  closeModal();
                }}
              >
                Mantener Sesión
              </Button>
            </ModalFooter>
          </>
        )}
      </ModalContent>
    </Modal>
  );
}

ModalSessionExpiration.propTypes = {
  isOpen: PropTypes.bool.isRequired,
  onClose: PropTypes.func.isRequired,
  onKeepSession: PropTypes.func.isRequired,
  onLogout: PropTypes.func.isRequired,
  type: PropTypes.oneOf(["inactividad", "expiracion"]).isRequired,
};
