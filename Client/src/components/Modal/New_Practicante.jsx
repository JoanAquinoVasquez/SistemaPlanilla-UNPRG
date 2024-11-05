import {
  Modal,
  ModalContent,
  ModalHeader,
  ModalBody,
  ModalFooter,
  Button,
  Autocomplete,
  AutocompleteItem,
  Tabs,
  Tab,
  RadioGroup,
  Radio,
  Select,
  SelectItem,
} from "@nextui-org/react";
import ReusableInput from "../Inputs/InputField";
import RenderFileUpload from "../Inputs/RenderFileUpload";
import PropTypes from "prop-types";
import { bancos } from "../../Data/DataBancos";
import { unidadesUniversidad } from "../../Data/DataUnidad";
import { aportes } from "../../Data/DataAportes";
import { IoSearchSharp } from "react-icons/io5";
import { useState } from "react";

export default function Modal_New_Practicante({ isOpen, onClose }) {
  const [selectedDocumento, setSelectedDocumento] = useState("");

  const handleSelectChange = (value) => {
    setSelectedDocumento(value);
  };
  return (
    <Modal
      backdrop="opaque"
      isOpen={isOpen}
      onOpenChange={onClose}
      placement="top-center"
      size="4xl"
    >
      <ModalContent>
        {(closeModal) => (
          <>
            <ModalHeader className="flex flex-col gap-1">
              Nuevo Practicante
            </ModalHeader>

            <ModalBody>
              <section className="relative p-4 border border-gray-300 rounded-lg">
                <h2 className="absolute -top-3 left-4 bg-white px-2 text-lg font-semibold">
                  Datos Personales
                </h2>
                <div className="flex w-full flex-wrap md:flex-nowrap gap-4 mt-4 items-center">
                  <Select
                    label="Tipo de Documento"
                    variant="flat"
                    className="w-60"
                    onChange={(e) => handleSelectChange(e.target.value)}
                  >
                    <SelectItem value="DNI">DNI</SelectItem>
                    <SelectItem value="carnet_extranjeria">
                      Carnet de Extranjería
                    </SelectItem>
                  </Select>

                  {selectedDocumento && (
                    <ReusableInput
                      label={
                        selectedDocumento === "$.0"
                          ? "DNI"
                          : "Carnet de Extranjería"
                      }
                      className="w-60"
                    />
                  )}

                  <Button>
                    <IoSearchSharp />
                  </Button>
                </div>

                <hr />

                <div className="flex w-full flex-wrap md:flex-nowrap gap-4 mt-4">
                  {[
                    "Apellido Paterno",
                    "Apellido Materno",
                    "Nombre Completo",
                  ].map((label, index) => (
                    <ReusableInput
                      key={index}
                      label={label}
                      className={
                        index === 2
                          ? "flex-1 min-w-[200px]"
                          : "flex-1 min-w-[150px]"
                      }
                    />
                  ))}
                </div>

                <div className="flex w-full flex-wrap md:flex-nowrap gap-4 mt-4">
                  <ReusableInput label="Número de Celular" className="w-40" />
                  <Autocomplete
                    label="Banco"
                    variant="flat"
                    defaultItems={bancos}
                    className="flex-1 min-w-[150px]"
                    style={{ paddingBottom: "0px", paddingLeft: "0px" }}
                  >
                    {(item) => (
                      <AutocompleteItem key={item.value}>
                        {item.label}
                      </AutocompleteItem>
                    )}
                  </Autocomplete>
                  <ReusableInput
                    label="Número de cuenta"
                    className="flex-1 min-w-[200px]"
                  />
                </div>
              </section>

              {/* Sección de Datos Laborales */}
              <section className="relative p-4 border border-gray-300 rounded-lg mt-4">
                <h2 className="absolute -top-3 left-4 bg-white px-2 text-lg font-semibold">
                  Datos Laborales
                </h2>

                <div className="flex w-full flex-wrap md:flex-nowrap gap-4 mt-4 items-center">
                  <Autocomplete
                    isRequired
                    label="Unidad Laboral"
                    variant="flat"
                    defaultItems={unidadesUniversidad}
                    className="flex-1 min-w-[150px]"
                    style={{ paddingBottom: "0px", paddingLeft: "0px" }}
                  >
                    {(item) => (
                      <AutocompleteItem key={item.value}>
                        {item.label}
                      </AutocompleteItem>
                    )}
                  </Autocomplete>
                  <Tabs radius="lg">
                    <Tab key="preprofesional" title="PRE-PROFESIONAL" />
                    <Tab key="profesional" title="PROFESIONAL" />
                  </Tabs>
                </div>

                <div className="flex w-full flex-wrap md:flex-nowrap gap-4 mt-4 items-center justify-between">
                  <RadioGroup label="Aportante" isRequired>
                    {aportes.map((aporte) => (
                      <Radio key={aporte.value} value={aporte.value}>
                        {aporte.label}
                      </Radio>
                    ))}
                  </RadioGroup>
                  <div className="flex flex-col gap-4">
                    {["Contrato", "Copia DNI", "Curriculum Vitae"].map(
                      (labelText, index) => (
                        <RenderFileUpload
                          key={index}
                          labelText={labelText}
                          inputId={`file-upload-${index}`}
                        />
                      )
                    )}
                  </div>
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
