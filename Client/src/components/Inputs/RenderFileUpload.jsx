import { Button } from "@nextui-org/react";
import PropTypes from "prop-types";

export default function FileUploadButton({ labelText, inputId }) {
    const handleFileUploadClick = () => {
        // Esto abre el cuadro de diálogo para seleccionar un archivo
        document.getElementById(inputId).click();
    };

    return (
        <div className="flex items-center border rounded-xl shadow-sm overflow-hidden">
            <label htmlFor={inputId} className="flex-1 px-4 py-2 bg-gray-100 cursor-pointer text-gray-600">
                {labelText}
            </label>
            <input id={inputId} type="file" className="hidden" />
            <Button
                auto
                className="bg-blue-500 text-white font-semibold hover:bg-blue-600 transition"
                onClick={handleFileUploadClick}
            >
                Subir
            </Button>
        </div>
    );
}

FileUploadButton.propTypes = {
    labelText: PropTypes.string.isRequired,
    inputId: PropTypes.string.isRequired,
};
