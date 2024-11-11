import { useEffect, useState } from "react";
import axios from "axios";

export default function useDocumentos() {
  const [documentos, setDocumentos] = useState([]);
  const [loading, setLoading] = useState(true); // Estado de carga

  useEffect(() => {
    const fetchDocumentos = async () => {
      try {
        setLoading(true); // Inicia la carga
        const response = await axios.get(
          "/documentos"
        );
        const documentosData = response.data.map((documento) => ({
          id: documento.id,
          nombre: documento.nombre,
          tipo: documento.tipo,
          fecha_vigencia: documento.fecha_vigencia,
          fecha_fin: documento.fecha_fin,
          estado: documento.estado,
          created_at: documento.created_at,
          updated_at: documento.updated_at,
        }));
        setDocumentos(documentosData);
      } catch (error) {
        console.error("Error al cargar los documentos:", error);
      } finally {
        setLoading(false); // Termina la carga
      }
    };

    fetchDocumentos();
  }, []);

  return { documentos, loading, columns, statusOptions };
}

// Columnas fijas para la tabla de documentos
export const columns = [
  { name: "ID", uid: "id", sortable: true },
  { name: "NOMBRE", uid: "nombre", sortable: true },
  { name: "TIPO", uid: "tipo", sortable: true },
  { name: "FECHA VIGENCIA", uid: "fecha_vigencia", sortable: true },
  { name: "FECHA FIN", uid: "fecha_fin", sortable: true },
  { name: "ESTADO", uid: "estado", sortable: true },
  { name: "ACCIONES", uid: "accciones" },
];

// Opciones fijas para el estado de los documentos (solo Activo e Inactivo)
export const statusOptions = [
  { name: "Activo", uid: 1 },
  { name: "Inactivo", uid: 0 },
];
