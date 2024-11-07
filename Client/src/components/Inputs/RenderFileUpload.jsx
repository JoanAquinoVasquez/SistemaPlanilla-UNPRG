import { useState } from "react";
import { Button, Input } from "@nextui-org/react";
import propTypes from "prop-types";
import { toast, Toaster } from "react-hot-toast";

const RenderFileUpload = ({
  inputId,
  buttonText,
  placeholderText,
  showCommentInput = true,
}) => {
  const [fileName, setFileName] = useState("");

  const handleFileChange = async (event) => {
    const file = event.target.files[0];

    // Función para validar el archivo
    const validateFile = () => {
      return new Promise((resolve, reject) => {
        
        if (!file) reject("No se ha seleccionado ningún archivo.");

        if (file.type !== "application/pdf") {
          reject("El archivo debe ser un PDF.");
        } else if (file.size > 10 * 1024 * 1024) {
          reject("El archivo debe ser menor de 10MB.");
        } else {
          resolve("El archivo se ha subido correctamente.");
        }
      });
    };

    // Usamos toast.promise para mostrar los mensajes en diferentes casos
    toast.promise(
      validateFile().then(() => setFileName(file.name)),
      {
        loading: "Verificando archivo...",
        success: "El archivo se ha subido correctamente",
        error: (err) => <p>{err}</p>,
      }
    );
  };

  const handleUploadClick = () => {
    document.getElementById(inputId).click();
  };

  return (
    <div style={{ display: "flex", flexDirection: "column", width: "100%" }}>
      {/* Contenedor del botón y el input de comentario opcional */}
      <div style={{ display: "flex", alignItems: "center" }}>
        <Toaster position="top-right" reverseOrder={false} />
        <Button
          auto
          onClick={handleUploadClick}
          bordered
          color="primary"
          className="w-full"
        >
          {buttonText}
        </Button>
        {/* Mostrar el input de comentario solo si showCommentInput es true */}
        {showCommentInput && (
          <Input
            placeholder={placeholderText}
            onChange={(e) => console.log("Texto ingresado:", e.target.value)}
          />
        )}
      </div>

      {/* Nombre del archivo seleccionado */}
      {fileName && (
        <p style={{ fontSize: "12px", color: "gray", marginTop: "5px" }}>
          {fileName}
        </p>
      )}

      {/* Input oculto para seleccionar archivo con un ID único */}
      <input
        id={inputId}
        type="file"
        style={{ display: "none" }}
        onChange={handleFileChange}
      />
    </div>
  );
};

RenderFileUpload.propTypes = {
  buttonText: propTypes.string,
  placeholderText: propTypes.string,
  showCommentInput: propTypes.bool,
  inputId: propTypes.string.isRequired,
};

export default RenderFileUpload;
