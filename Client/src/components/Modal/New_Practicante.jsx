import {
    Modal,
    ModalContent,
    ModalHeader,
    ModalBody,
    ModalFooter,
    Input,
    Button,
    Autocomplete,
    AutocompleteItem,
    Tabs,
    Tab,
    RadioGroup,
    Radio,
} from "@nextui-org/react";
import propTypes from "prop-types";
import { bancos } from "../../data/dataBancos";

export default function Modal_New_Practicante({ isOpen, onClose }) {
    const handleFileUploadClick = (id) => {
        document.getElementById(id).click();
    };

    const renderInput = (label, type = "text", className = "", isRequired = true) => (
        <Input
            isRequired={isRequired}
            type={type}
            label={label}
            className={className}
            style={{ paddingBottom: "0px", paddingLeft: "0px" }}
            onClear={() => console.log("input cleared")}
        />
    );

    const renderFileUpload = (labelText, index) => {
        const inputId = `file-upload-${index}`;
        return (
            <div
                key={index}
                className="flex items-center border border-gray-300 rounded-xl overflow-hidden shadow-sm"
            >
                <label
                    htmlFor={inputId}
                    className="flex-1 px-4 py-2 text-gray-600 bg-gray-100 cursor-pointer"
                >
                    {labelText}
                </label>
                <input
                    id={inputId}
                    type="file"
                    className="hidden"
                />
                <Button
                    auto
                    className="bg-blue-500 text-white font-semibold hover:bg-blue-600 transition duration-200"
                    onClick={() => handleFileUploadClick(inputId)}
                >
                    Subir
                </Button>
            </div>
        );
    };

    return (
        <Modal
            backdrop={"blur"}
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

                                <div className="flex w-full flex-wrap md:flex-nowrap gap-4 mt-4">
                                    {renderInput("Apellido Paterno", "text", "flex-1 min-w-[150px]")}
                                    {renderInput("Apellido Materno", "text", "flex-1 min-w-[150px]")}
                                    {renderInput("Nombre Completo", "text", "flex-1 min-w-[200px]")}
                                </div>

                                <div className="flex w-full flex-wrap md:flex-nowrap gap-4 mt-4">
                                    {renderInput("DNI", "text", "w-32")}
                                    {renderInput("Número de Celular", "text", "w-40")}
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
                                    {renderInput("Número de cuenta", "text", "flex-1 min-w-[200px]")}
                                </div>
                            </section>

                            <section className="relative p-4 border border-gray-300 rounded-lg mt-4">
                                <h2 className="absolute -top-3 left-4 bg-white px-2 text-lg font-semibold">
                                    Datos Laborales
                                </h2>

                                <div className="flex w-full flex-wrap md:flex-nowrap gap-4 mt-4 items-center">
                                    <Autocomplete
                                        isRequired
                                        label="Unidad Laboral"
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
                                    <Tabs radius={"lg"}>
                                        <Tab key="preprofesional" title="PRE-PROFESIONAL" />
                                        <Tab key="profesional" title="PROFESIONAL" />
                                    </Tabs>
                                </div>

                                <div className="flex w-full flex-wrap md:flex-nowrap gap-4 mt-4 items-center justify-between">
                                    <RadioGroup label="Aportante" isRequired>
                                        <Radio value="onp">ONP</Radio>
                                        <Radio value="afpprima">AFP - PRIMA</Radio>
                                        <Radio value="afphabitat">AFP - HABITAT</Radio>
                                        <Radio value="afpintegra">AFP - INTEGRA</Radio>
                                        <Radio value="afpprofoturo">AFP - PROFUTURO</Radio>
                                    </RadioGroup>
                                    <div className="flex flex-col gap-4">
                                        {["Contrato", "Copia DNI", "Curriculum Vitae"].map(renderFileUpload)}
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
    isOpen: propTypes.bool,
    onClose: propTypes.func,
};
