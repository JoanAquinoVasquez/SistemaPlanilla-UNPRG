import { Input } from "@nextui-org/react";
import PropTypes from "prop-types";

export default function ReusableInput({ label, type = "text", className = "", isRequired = true }) {
    return (
        <Input
            isRequired={isRequired} /* Propiedad para hacer que el input sea obligatorio*/ 
            type={type}  /*Tipo de input, por defecto es "text"*/ 
            label={label} /*Etiqueta que describe el input (por ejemplo, "Nombre Completo", "DNI", etc.)*/ 
            className={className} /*Clase CSS personalizada que se puede pasar para modificar el estilo del input*/ 
            style={{ paddingBottom: "0px", paddingLeft: "0px" }} /*Estilos en línea específicos para eliminar el padding inferior e izquierdo*/ 
            onClear={() => console.log(`${label} input cleared`)} /*Callback que se ejecuta cuando el input es borrado, por ejemplo, al hacer clic en el botón de limpiar*/
        />
    );
}

ReusableInput.propTypes = {
    label: PropTypes.string.isRequired,
    type: PropTypes.string,
    className: PropTypes.string,
    isRequired: PropTypes.bool,
};
