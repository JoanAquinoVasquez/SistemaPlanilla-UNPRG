import { useState } from "react";
import { Button, Input } from "@nextui-org/react";
import propTypes from "prop-types";

const RenderFileUpload = ({ inputId, buttonText, placeholderText, showCommentInput = true }) => {
  const [fileName, setFileName] = useState('');

  const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
      setFileName(file.name);
    }
  };

  const handleUploadClick = () => {
    document.getElementById(inputId).click();
  };

  return (
    <div style={{ display: 'flex', flexDirection: 'column',  width: '100%' }}>
      {/* Contenedor del botón y el input de comentario opcional */}
      <div style={{ display: 'flex', alignItems: 'center' }}>
        
        <Button auto onClick={handleUploadClick} bordered color="primary" className="w-full">
          {buttonText}
        </Button>
        
        {/* Mostrar el input de comentario solo si showCommentInput es true */}
        {showCommentInput && (
          <Input
            placeholder={placeholderText}
            onChange={(e) => console.log('Texto ingresado:', e.target.value)}
          />
        )}
      </div>

      {/* Nombre del archivo seleccionado */}
      {fileName && (
        <p style={{ fontSize: '12px', color: 'gray', marginTop: '5px' }}>
          {fileName}
        </p>
      )}

      {/* Input oculto para seleccionar archivo con un ID único */}
      <input
        id={inputId}
        type="file"
        style={{ display: 'none' }}
        onChange={handleFileChange}
      />
    </div>
  );
};

RenderFileUpload.propTypes = {
  buttonText: propTypes.string,
  placeholderText: propTypes.string,
  showCommentInput: propTypes.bool,
    inputId: propTypes.string,
};

export default RenderFileUpload;
