import { Spinner as NextUISpinner } from "@nextui-org/react"; // Cambia el nombre aquí
import "./Spinner.css";

const Spinner = ({label}) => {
  return (
    <div className="spinner-container">
      <NextUISpinner size="lg" label={label} />
    </div>
  );
};

export default Spinner;
