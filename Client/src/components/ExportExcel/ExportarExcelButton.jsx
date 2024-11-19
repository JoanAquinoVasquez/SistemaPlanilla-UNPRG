// ExportarExcelButton.js
import { Button } from "@nextui-org/react";
import { FaUpload } from "react-icons/fa";
import axios from "axios";

const ExportarExcelButton = () => {
  const exportarExcel = async () => {
    try {
      // Realiza la solicitud GET para descargar el archivo Excel
      const response = await axios.get("http://localhost:8000/api/exportar-reporte-practicante", {
        responseType: "blob",
      });

      // Convierte la respuesta en un blob y crea una URL para descargar
      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute("download", "reportePracticante.xlsx"); // Nombre del archivo
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link); // Limpia el enlace después de la descarga
    } catch (error) {
      console.error("Error al descargar el archivo:", error);
    }
  };

  return (
    <Button auto light className="w-full sm:w-auto" onClick={exportarExcel}>
      <FaUpload className="mr-2" />
      Exportar
    </Button>
  );
};

export default ExportarExcelButton;
