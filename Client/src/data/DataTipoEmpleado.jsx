import { useEffect, useState } from "react";
import axios from "axios";

export default function useTipoEmpleado() {
  const [tipoempleado, setTipoEmpleados] = useState([]); // Renombrar para mayor claridad

  useEffect(() => {
    const fetchTipoEmpleados = async () => {
      try {
        const response = await axios.get("/tipo-empleados");
        const tipoempleadoData = response.data.map((empleado) => ({
          label: empleado.nombre,
        }));
        console.log("tipoempleadoData", tipoempleadoData);

        setTipoEmpleados(tipoempleadoData); // Actualizar el estado correctamente
      } catch (error) {
        console.error("Error al cargar los tipo empleados:", error);
      }
    };

    fetchTipoEmpleados();
  }, []);

  return tipoempleado; // Retorna el estado correcto
}
