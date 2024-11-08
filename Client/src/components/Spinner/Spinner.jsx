import { Spinner as NextUISpinner } from "@nextui-org/react"; // Cambia el nombre aquí
import PropTypes from "prop-types";

const Spinner = ({ label }) => {
  return (
    <div className="fixed inset-0 flex justify-center items-center bg-white bg-opacity-80 z-50">
      <NextUISpinner size="lg" label={label} />
    </div>
  );
};

Spinner.propTypes = {
  label: PropTypes.string,
};

export default Spinner;
