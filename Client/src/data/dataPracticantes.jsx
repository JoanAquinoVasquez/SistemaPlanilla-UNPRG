import { useEffect, useState, useCallback } from "react";
import axios from "axios";
  
export default function usePracticantes() {
  const [practicantes, setPracticantes] = useState([]);
  const [loading, setLoading] = useState(true);
  const fetchPracticantes = useCallback(async () => {
    try {
      setLoading(true);
      const response = await axios.get("/all-empleado-tipo/3");
      const practicantesData = response.data.data.map((practicante) => ({ // Aquí cambiamos a response.data.data
        id: practicante.empleado_num_doc_iden, // Usado como clave única
        tipo_doc_iden: practicante.empleado.tipo_doc_iden,
        dni: practicante.empleado_num_doc_iden,
        name: `${practicante.empleado.apellido_paterno} ${practicante.empleado.apellido_materno} ${practicante.empleado.nombres}`,
        email: practicante.empleado.email,
        numerodecuenta: practicante.numero_cuenta,
        cci: practicante.cci,
        estado: practicante.estado,
        banco: practicante.banco?.nombre || "Sin asignar",
        unidad: practicante.area_activa?.area?.nombre || "Sin asignar",
        oficina_area: practicante.area_activa?.area?.oficina || "Sin asignar",
        sub_tipo_empleado: practicante.sub_tipo_empleado.nombre || "Sin asignar",
        aporte: practicante.aportacion_pension?.concepto || "Sin asignar",
      }));
      setPracticantes(practicantesData);
      console.log("Practicantes cargados:", practicantesData);
    } catch (error) {
      console.error("Error al cargar los practicantes:", error);
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    fetchPracticantes();
  }, [fetchPracticantes]);

  return { practicantes, loading, fetchPracticantes, columns, statusOptions };
}

  
export const columns = [
  { name: "NOMBRE COMPLETO", uid: "name", sortable: true },
  { name: "TIPO DE DOC.", uid: "tipo_doc_iden" },
  { name: "NUMERO DE CUENTA", uid: "numerodecuenta" },
  { name: "UNIDAD", uid: "unidad", sortable: true },
  { name: "SUBTIPO", uid: "sub_tipo_empleado", sortable: true }, // Subtipo agregado
  { name: "APORTE", uid: "aporte", sortable: true },
  { name: "ESTADO", uid: "estado", sortable: true },
  { name: "ACCIONES", uid: "accciones" },
];
export const statusOptions = [
  { name: "Activo", uid: "1" },
  { name: "Inactivo", uid: "0" },
];
