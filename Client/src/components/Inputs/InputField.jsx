import { Input } from "@nextui-org/react";
import PropTypes from "prop-types";

export default function ReusableInput({
    label,
    type = "text",
    className = "",
    isRequired = true,
    onChange,
    value,
}) {
    const handleClear = () => {
        if (onChange) {
            onChange({ target: { value: "" } }); // Simular un evento de cambio con valor vacío
        }
    };

    return (
        <Input
            isRequired={isRequired} // Indica si el input es obligatorio
            type={type} // Tipo de input (texto, contraseña, etc.)
            label={label} // Etiqueta del input
            className={className} // Clase CSS personalizada
            style={{ paddingBottom: "0px", paddingLeft: "0px" }} // Estilos personalizados
            onClear={handleClear} // Manejar el evento onClear
            onChange={onChange} // Callback para manejar cambios
            value={value} // Asignar el valor controlado
        />
    );
}

ReusableInput.propTypes = {
    label: PropTypes.string.isRequired,
    type: PropTypes.string,
    className: PropTypes.string,
    isRequired: PropTypes.bool,
    onChange: PropTypes.func,
    value: PropTypes.string,
};
