// Databancos.jsx
import { useEffect, useState } from "react";
import axios from "axios";

export default function useBancos() {
  const [bancos, setBancos] = useState([]);

  useEffect(() => {
    const fetchBancos = async () => {
      try {
        const response = await axios.get("/bancos", {});
        const bancosData = response.data.map((banco) => ({
          label: banco.nombre,
          value: banco.id,
        }));
        setBancos(bancosData);
      } catch (error) {
        console.error("Error al cargar los bancos:", error);
      }
    };

    fetchBancos();
  }, []);

  return bancos;
}
