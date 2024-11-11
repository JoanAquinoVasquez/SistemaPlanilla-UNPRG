import { Modal, ModalContent, ModalHeader, ModalBody, ModalFooter, Button } from "@nextui-org/react";
import PropTypes from "prop-types";

export default function ModalSessionExpiration({ isOpen, onClose, onKeepSession, onLogout }) {
  return (
    <Modal backdrop="opaque" isOpen={isOpen} onOpenChange={onClose} placement="top-center" size="lg">
      <ModalContent>
        {(closeModal) => (
          <>
            <ModalHeader className="flex flex-col gap-1">
              Sesión a punto de Expirar
            </ModalHeader>

            <ModalBody>
              <p className="text-center text-lg">
                Su sesión está a punto de expirar. ¿Desea mantener su sesión o cerrar sesión?
              </p>
            </ModalBody>

            <ModalFooter>
              <Button color="danger" variant="flat" onPress={() => { 
                onLogout(); // Llama a onLogout, que contiene la función `handleLogout`
                closeModal();
              }}>
                Cerrar Sesión
              </Button>
              <Button color="primary" onPress={() => {
                onKeepSession();
                closeModal();
              }}>
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
};
