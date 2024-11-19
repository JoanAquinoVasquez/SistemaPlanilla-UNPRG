import { useEffect, useState } from "react";
import axios from "axios";
import Echo from "../echo"; // Importa tu configuración de Echo

export default function useFormulas() {
  const [formulas, setFormulas] = useState([]);
  const [activeCount, setActiveCount] = useState(0);
  const [inactiveCount, setInactiveCount] = useState(0);

  // Función para actualizar los contadores de activas e inactivas
  const updateCounts = (formulas) => {
    setActiveCount(formulas.filter((f) => f.estado).length);
    setInactiveCount(formulas.filter((f) => !f.estado).length);
  };

  const fetchFormulas = async () => {
    try {
      const { data } = await axios.get("/formulas");
      setFormulas(data);
      updateCounts(data);
    } catch (error) {
      console.error("Error al cargar fórmulas:", error);
    }
  };

  useEffect(() => {
    fetchFormulas();
    // Suscribirse al canal "formulas" para escuchar eventos en tiempo real

    const channel = Echo.channel("formulas");
    // Escucha del evento ".formula.added" cuando se añade una fórmula nueva

    channel.listen(".formula.added", ({ formula }) => {
      console.log("Nueva fórmula recibida desde WebSocket:", formula);
      setFormulas((prev) => {
        const updated = [...prev.filter((f) => f.id !== formula.id), formula];
        updateCounts(updated);
        return updated;
      });
    });
    // Limpieza al desmontar el componente
    return () => Echo.leaveChannel("formulas");
  }, []);

  return { formulas, activeCount, inactiveCount };
}
