import { Spinner as NextUISpinner } from "@nextui-org/react"; // Cambia el nombre aquí
import PropTypes from "prop-types";

const Spinner = ({label}) => {
  return (
    <div className="flex justify-center items-center h-screen w-screen">
      <NextUISpinner size="lg" label={label} />
    </div>
  );
};

Spinner.propTypes = {
  label: PropTypes.string,
};

export default Spinner;
