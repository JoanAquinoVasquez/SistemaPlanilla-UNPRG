import { useState } from "react";
import {
    Modal,
    ModalContent,
    ModalHeader,
    ModalBody,
    ModalFooter,
    Button,
    Autocomplete,
    AutocompleteItem,
    RadioGroup,
    Radio,
    DatePicker,
} from "@nextui-org/react";
import ReusableInput from "../Inputs/InputField";
import PropTypes from "prop-types";
import { tiposdocs } from "../../data/DataTipoDoc";
import axios from "axios";
import { toast, Toaster } from "react-hot-toast";

export default function Modal_New_Documento({ isOpen, onClose, onDocumentCreated }) {
    const [nombre, setNombre] = useState("");
    const [tipo, setTipo] = useState("");
    const [fechaVigencia, setFechaVigencia] = useState(null);
    const [fechaFin, setFechaFin] = useState(null);
    const [estado, setEstado] = useState(true);

    const handleSave = async () => {
        try {
            if (!fechaVigencia) {
                toast.error("La fecha de inicio es requerida.");
                return;
            }
            if (!nombre.trim()) {
                toast.error("El nombre del documento es requerido.");
                return;
            }
            if (!tipo) {
                toast.error("El tipo de documento es requerido.");
                return;
            }
            if (fechaVigencia && fechaFin && new Date(fechaFin) < new Date(fechaVigencia)) {
                toast.error("La fecha de fin no puede ser menor a la fecha de inicio.");
                return;
            }

            const data = {
                nombre,
                tipo,
                fecha_vigencia: fechaVigencia,
                fecha_fin: fechaFin || null,
                estado,
            };

            await axios.post("/documentos", data);
            setNombre("");
            setTipo("");
            setFechaVigencia(null);
            setFechaFin(null);
            setEstado(true);
            onClose();
            onDocumentCreated();

            setTimeout(() => {
                toast.success("Documento guardado correctamente.");
            }, 1000); // Retraso de 1 segundo


        } catch (error) {
            toast.error("Error al guardar el documento: " + (error.response?.data?.message || error.message));
        }
    };

    return (
        <Modal
            backdrop="opaque"
            isOpen={isOpen}
            onOpenChange={onClose}
            placement="top-center"
            size="3xl"
        >
            <Toaster position="top-right" reverseOrder={false} />

            <ModalContent>
                {(closeModal) => (
                    <>
                        <ModalHeader className="flex flex-col gap-1">
                            Nuevo Documento
                        </ModalHeader>
                        <ModalBody>

                            <div className="flex flex-col md:flex-row gap-4">
                                <section className="relative flex-[3] p-4 border border-gray-300 rounded-lg">
                                    <div className="flex flex-wrap gap-4 mt-4">
                                        <ReusableInput
                                            label="Nombre del documento"
                                            aria-label="Nombre del documento"
                                            className="flex-1 min-w-200"
                                            value={nombre}
                                            onChange={(e) => setNombre(e.target.value)}
                                        />
                                        <Autocomplete
                                            label="Tipo de documento"
                                            variant="flat"
                                            defaultItems={tiposdocs}
                                            className="flex-1 min-w-200"
                                            style={{ paddingLeft: "0", paddingBottom: "0" }}
                                            onSelectionChange={(key) => setTipo(key)}
                                        >
                                            {(item) => (
                                                <AutocompleteItem key={item.value}>
                                                    {item.label}
                                                </AutocompleteItem>
                                            )}
                                        </Autocomplete>
                                    </div>
                                    <div className="flex flex-wrap gap-4 mt-4">
                                        <DatePicker
                                            isRequired
                                            label="Fecha de inicio de vigencia"
                                            className="flex-1 min-w-200"
                                            aria-label="Fecha de inicio"
                                            onChange={(value) =>
                                                setFechaVigencia(value?.toString())
                                            }
                                        />
                                        <DatePicker
                                            label="Fecha de Fin"
                                            className="flex-1 min-w-200"
                                            aria-label="Fecha de fin"
                                            onChange={(value) =>
                                                setFechaFin(value?.toString())
                                            }
                                        />
                                        <RadioGroup
                                            value={estado ? "true" : "false"}
                                            onChange={(e) => {
                                                const value = e.target.value;
                                                const nuevoEstado = value === "true";
                                                setEstado(nuevoEstado);
                                                console.log("Estado después de setEstado:", nuevoEstado);
                                            }}
                                        >
                                            <Radio value="true">Activo</Radio>
                                            <Radio value="false">Inactivo</Radio>
                                        </RadioGroup>

                                    </div>
                                </section>
                            </div>
                        </ModalBody>
                        <ModalFooter>
                            <Button
                                color="danger"
                                variant="flat"
                                onPress={closeModal}
                            >
                                Cerrar
                            </Button>
                            <Button color="primary" onPress={handleSave}>
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
    onDocumentCreated: PropTypes.func, // Cambié onRefresh a onDocumentCreated
};
