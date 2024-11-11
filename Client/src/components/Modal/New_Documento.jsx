import { Modal, ModalContent, ModalHeader, ModalBody, ModalFooter, Button, Autocomplete, AutocompleteItem, DateInput, RadioGroup, Radio } from "@nextui-org/react";
import ReusableInput from "../Inputs/InputField";
import PropTypes from "prop-types";
import useBancos from "../../Data/DataBancos";

import { CalendarDate } from "@internationalized/date";
export default function Modal_New_Documento({ isOpen, onClose }) {
    const bancos = useBancos();


    return (
        <Modal backdrop="opaque" isOpen={isOpen} onOpenChange={onClose} placement="top-center" size="3xl">
            <ModalContent>
                {(closeModal) => (
                    <>
                        <ModalHeader className="flex flex-col gap-1">
                            Nuevo Documento
                        </ModalHeader>

                        <ModalBody>

                            {/* Contenedor en fila para los dos primeros sections */}
                            <div className="flex flex-col md:flex-row gap-4">
                                {/* Sección de Datos Personales */}
                                <section className="relative flex-[3] p-4 border border-gray-300 rounded-lg">
                                    <div className="flex flex-wrap gap-4 mt-4">
                                        <ReusableInput label="Nombre del documento" aria-label="Nombre del documento" className="flex-1 min-w-200" />
                                        <Autocomplete label="Tipo de documento" variant="flat" defaultItems={bancos} className="flex-1 min-w-200" style={{ paddingLeft: "0px", paddingBottom: "0px" }}>
                                            {(item) => <AutocompleteItem key={item.value}>{item.label}</AutocompleteItem>}
                                        </Autocomplete>
                                    </div>
                                    <div className="flex flex-wrap gap-4 mt-4">
                                        <DateInput isRequired label="Fecha de Inicio" placeholderValue={new CalendarDate(1995, 11, 6)} className="flex-1 min-w-200" aria-label="Fecha de incio" />
                                        <DateInput isRequired label="Fecha de Fin" placeholderValue={new CalendarDate(1995, 11, 6)} className="flex-1 min-w-200" aria-label="Fecha de fin" />
                                        <RadioGroup
                                        >
                                            <Radio value="buenos-aires">Activo</Radio>
                                            <Radio value="sydney">Inactivo</Radio>

                                        </RadioGroup>
                                    </div>
                                </section>
                            </div>

                        </ModalBody>
                        <ModalFooter>
                            <Button color="danger" variant="flat" onPress={closeModal}>
                                Cerrar
                            </Button>
                            <Button color="primary" onPress={closeModal}>
                                Guardar
                            </Button>
                        </ModalFooter>
                    </>
                )}
            </ModalContent>
        </Modal>

    );
}

Modal_New_Documento.propTypes = {
    isOpen: PropTypes.bool,
    onClose: PropTypes.func,
};
