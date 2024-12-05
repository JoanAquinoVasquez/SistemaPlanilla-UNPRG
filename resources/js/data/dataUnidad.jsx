
import { useEffect, useState } from "react";
import axios from "axios";

export default function useAreas() {
  const [areas, setAreas] = useState([]);

  useEffect(() => {
    const fetchAreas = async () => {
      try {
        const response = await axios.get("/areas", {});
        const areasData = response.data.map((area) => ({
          label: area.nombre,
          value: area.id,
        }));
        setAreas(areasData);
      } catch (error) {
        console.error("Error al cargar las areas:", error);
      }
    };

    fetchAreas();
  }, []);

  return areas;
}
