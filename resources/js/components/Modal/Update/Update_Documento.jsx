import { useEffect, useState } from "react";
import { Modal, ModalContent, ModalHeader, ModalBody, ModalFooter, Button, Autocomplete, AutocompleteItem, RadioGroup, Radio, DatePicker } from "@nextui-org/react";
import ReusableInput from "../../Inputs/InputField";
import PropTypes from "prop-types";
import { tiposdocs } from "../../../data/dataTipoDoc";
import axios from "axios";
import { toast, Toaster } from "react-hot-toast";
import { parseDate } from "@internationalized/date";

export default function Modal_Update_Documento({ isOpen, onClose, document, onDocumentUpdated }) {
    const [nombre, setNombre] = useState("");
    const [tipo, setTipo] = useState("");
    const [fechaVigencia, setFechaVigencia] = useState(null);
    const [fechaFin, setFechaFin] = useState(null);
    const [estado, setEstado] = useState(true);

    useEffect(() => {
        if (document) {
            setNombre(document.nombre || "");
            setTipo(document.tipo || "");
            setEstado(document.estado === 1);
            setFechaVigencia(document.fecha_vigencia ? new Date(document.fecha_vigencia).toISOString().split("T")[0] : null);
            setFechaFin(document.fecha_fin ? new Date(document.fecha_fin).toISOString().split("T")[0] : null);
        }
    }, [document]);

    const handleSave = async () => {
        try {
            if (!fechaVigencia || !nombre.trim() || !tipo) return toast.error("Campos requeridos.");
            if (fechaVigencia && fechaFin && new Date(fechaFin) <= new Date(fechaVigencia)) return toast.error("La fecha de fin debe ser mayor a la fecha de inicio.");

            const updatedData = { nombre, tipo, fecha_vigencia: fechaVigencia, fecha_fin: fechaFin || null, estado };
            await axios.put(`/documentos/${document.id}`, updatedData);
            onClose();
            onDocumentUpdated();
            setTimeout(() => {
                toast.success("Documento actualizado.");
            }, 1000);
        } catch (error) {
            toast.error("Error al actualizar el documento");
            console.error(error);
        }
    };

    return (
        <Modal backdrop="opaque" isOpen={isOpen} onOpenChange={onClose} placement="top-center" size="3xl">
            <Toaster position="top-right" reverseOrder={false} />

            <ModalContent>
                {(closeModal) => (
                    <>
                        <ModalHeader className="flex flex-col gap-1">  Modificar Documento </ModalHeader>
                        <ModalBody>
                            <div className="flex flex-col md:flex-row gap-4">
                                <section className="relative flex-[3] p-4 border border-gray-300 rounded-lg">
                                    <div className="flex flex-wrap gap-4 mt-4">
                                        <ReusableInput label="Nombre del documento" aria-label="Nombre del documento" className="flex-1 min-w-200" value={nombre} onChange={(e) => setNombre(e.target.value)} />
                                        <Autocomplete label="Tipo de documento" variant="flat" defaultItems={tiposdocs} className="flex-1 min-w-200" style={{ paddingLeft: "0", paddingBottom: "0" }} selectedKey={tipo} onSelectionChange={(key) => setTipo(key)} >
                                            {(item) => (
                                                <AutocompleteItem key={item.value}>
                                                    {item.label}
                                                </AutocompleteItem>
                                            )}
                                        </Autocomplete>
                                    </div>
                                    <div className="flex flex-wrap gap-4 mt-4">
                                        <DatePicker label="Fecha de inicio de vigencia" className="flex-1 min-w-200" aria-label="Fecha de inicio" defaultValue={document.fecha_vigencia ? parseDate(document.fecha_vigencia) : undefined} // Validación aquí
                                            onChange={(value) =>
                                                setFechaVigencia(value?.toString())
                                            } />
                                        <DatePicker label="Fecha de Fin" className="flex-1 min-w-200" aria-label="Fecha de fin" defaultValue={document.fecha_fin ? parseDate(document.fecha_fin) : undefined} 
                                            onChange={(value) =>
                                                setFechaFin(value?.toString())
                                            } />
                                        <RadioGroup
                                            value={estado ? "true" : "false"}
                                            onChange={(e) => setEstado(e.target.value === "true")} >
                                            <Radio value="true">Activo</Radio>
                                            <Radio value="false">Inactivo</Radio>
                                        </RadioGroup>
                                    </div>
                                </section>
                            </div>
                        </ModalBody>
                        <ModalFooter>
                            <Button color="danger" variant="flat" onPress={closeModal}> Cerrar </Button>
                            <Button color="primary" onPress={handleSave}> Modificar </Button>
                        </ModalFooter>
                    </>
                )}
            </ModalContent>
        </Modal>
    );
}

Modal_Update_Documento.propTypes = {
    isOpen: PropTypes.bool,
    onClose: PropTypes.func,
    document: PropTypes.object, // Documento seleccionado
    onDocumentUpdated: PropTypes.func, // Callback para actualizar la lista
};