import { Modal, ModalContent, ModalHeader, ModalBody, ModalFooter, Button, Autocomplete, AutocompleteItem, Tabs, Tab, Select, SelectItem, Divider, DateInput } from "@nextui-org/react";
import ReusableInput from "../Inputs/InputField";
import RenderFileUpload from "../Inputs/RenderFileUpload";
import PropTypes from "prop-types";
import useBancos from "../../Data/DataBancos";
import useAreas from "../../Data/DataUnidad";
import { aportes } from "../../Data/DataAportes";
import { IoSearchSharp } from "react-icons/io5";
import { useState } from "react";
import { CalendarDate } from "@internationalized/date";
export default function Modal_New_Practicante({ isOpen, onClose }) {
  const [selectedDocumento, setSelectedDocumento] = useState("");
  const bancos = useBancos();
  const areas = useAreas();
  const handleSelectChange = (value) => {
    setSelectedDocumento(value);
  };

  return (
    <Modal backdrop="opaque" isOpen={isOpen} onOpenChange={onClose} placement="top-center" size="5xl">
      <ModalContent>
        {(closeModal) => (
          <>
            <ModalHeader className="flex flex-col gap-1">
              Nuevo Practicante
            </ModalHeader>

            <ModalBody>

              {/* Contenedor en fila para los dos primeros sections */}
              <div className="flex flex-col md:flex-row gap-4">
                {/* Sección de Datos Personales */}
                <section className="relative flex-[3] p-4 border border-gray-300 rounded-lg">
                  <h2 className="absolute -top-3 left-4 bg-white px-2 text-lg font-semibold">Datos Personales</h2>
                  <div className="flex flex-wrap gap-4 mt-4 items-center">
                    <Select label="Tipo de Documento" variant="flat" className="w-60" onChange={(e) => handleSelectChange(e.target.value)} aria-label="Tipo de Documento">
                      <SelectItem value="DNI">DNI</SelectItem>
                      <SelectItem value="carnet_extranjeria">Carnet de Extranjería</SelectItem>
                    </Select>
                    {selectedDocumento && (
                      <ReusableInput label={selectedDocumento === "$.0" ? "DNI" : "Carnet de Extranjería"} className="w-60" aria-label="Número de Documento" />
                    )}
                    <Button aria-label="Buscar"><IoSearchSharp /></Button>
                  </div>
                  <Divider className="my-4" />
                  <div className="flex flex-wrap gap-4 mt-4">
                    {["Apellido Paterno", "Apellido Materno", "Nombre Completo"].map((label, i) => (
                      <ReusableInput key={i} label={label} className="flex-1 min-w-200" aria-label={label} />
                    ))}
                  </div>
                  <div className="flex flex-wrap gap-4 mt-4">
                    <ReusableInput label="Número de Celular" aria-label="Número de Celular" className="flex-1 min-w-200" />
                    <DateInput isRequired label="Fecha de Nacimiento" placeholderValue={new CalendarDate(1995, 11, 6)} className="flex-1 min-w-200" aria-label="Fecha de Nacimiento" />
                    <ReusableInput label="Correo electrónico" aria-label="Correo Electrónico" className="flex-1 min-w-200" />
                  </div>
                </section>

                {/* Sección de Datos Bancarios */}
                <section className="relative flex-1 p-4 border border-gray-300 rounded-lg mt-4 md:mt-0">
                  <h2 className="absolute -top-3 left-4 bg-white px-2 text-lg font-semibold">Datos Bancarios</h2>
                  <div className="flex flex-row md:flex-col w-full justify-around gap-4 mt-4 items-center">
                    <Autocomplete label="Banco" variant="flat" defaultItems={bancos} className="w-full md:max-w-[200px]" style={{ paddingLeft: "0px", paddingBottom: "0px" }}>
                      {(item) => <AutocompleteItem key={item.value}>{item.label}</AutocompleteItem>}
                    </Autocomplete>
                    {["Número de cuenta", "CCI"].map((label) => (
                      <ReusableInput key={label} label={label} className="w-full md:max-w-[200px]" />
                    ))}
                  </div>
                </section>
              </div>

              {/* Sección de Datos Laborales */}
              <section className="relative p-4 border border-gray-300 rounded-lg mt-4">
                <h2 className="absolute -top-3 left-4 bg-white px-2 text-lg font-semibold">Datos Laborales</h2>

                <div className="flex flex-wrap md:flex-nowrap gap-4 mt-4 items-center">
                  <Autocomplete label="Unidad Laboral" variant="flat" defaultItems={areas} className="flex-1 min-w-[150px]" isRequired style={{ paddingLeft: "0px", paddingBottom: "0px" }}>
                    {(item) => <AutocompleteItem key={item.value}>{item.label}</AutocompleteItem>}
                  </Autocomplete>

                  <Autocomplete label="Aportante" variant="flat" defaultItems={aportes} className="flex-1 min-w-[150px]" isRequired style={{ paddingLeft: "0px", paddingBottom: "0px" }}>
                    {(item) => <AutocompleteItem key={item.value}>{item.label}</AutocompleteItem>}
                  </Autocomplete>

                  <Tabs radius="lg">
                    <Tab key="preprofesional" title="PRE-PROFESIONAL" />
                    <Tab key="profesional" title="PROFESIONAL" />
                  </Tabs>

                </div>
                <div className="flex flex-wrap md:flex-nowrap gap-4 mt-4 items-center" >
                  {[
                    { buttonText: "Contrato", placeholderText: "N° de contrato", inputId: "dni", showCommentInput: true },
                    { buttonText: "Copia de DNI", inputId: "contrato", showCommentInput: false },
                    { buttonText: "Curriculum Vitae", inputId: "curriculum", showCommentInput: false }
                  ].map((fileProps, idx) => (
                    <RenderFileUpload key={idx} {...fileProps} />
                  ))}
                </div>
              </section>

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

Modal_New_Practicante.propTypes = {
  isOpen: PropTypes.bool,
  onClose: PropTypes.func,
};
