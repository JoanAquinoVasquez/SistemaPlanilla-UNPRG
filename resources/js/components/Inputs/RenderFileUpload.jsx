import { useState } from "react";
import { Button, Input } from "@nextui-org/react";
import propTypes from "prop-types";
import { toast, Toaster } from "react-hot-toast";

const RenderFileUpload = ({ inputId, buttonText, placeholderText, showCommentInput = true }) => {
  const [fileName, setFileName] = useState("");

  const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (!file) return toast.error("No se ha seleccionado ningún archivo.");
    if (file.type !== "application/pdf") return toast.error("El archivo debe ser un PDF.");
    if (file.size > 10 * 1024 * 1024) return toast.error("El archivo debe ser menor de 10MB.");

    setFileName(file.name);
    toast.success("El archivo se ha subido correctamente.");
  };

  return (
    <div style={{ display: "flex", flexDirection: "column", width: "100%" }}>
      <div style={{ display: "flex", alignItems: "center" }}>
        <Toaster position="top-right" />
        <Button auto bordered color="primary" className="w-full" onClick={() => document.getElementById(inputId).click()}>
          {buttonText}
        </Button>
        {showCommentInput && <Input placeholder={placeholderText} />}
      </div>
      {fileName && <p style={{ fontSize: "12px", color: "gray", marginTop: "5px" }}>{fileName}</p>}
      <input id={inputId} type="file" style={{ display: "none" }} onChange={handleFileChange} />
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
