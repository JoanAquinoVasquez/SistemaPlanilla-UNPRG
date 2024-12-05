import { Input } from "@nextui-org/react";
import PropTypes from "prop-types";

const ReusableInput = ({ label, type = "text", className = "", isRequired = true, onChange, value }) => (
  <Input
    isRequired={isRequired}
    type={type}
    label={label}
    className={className}
    style={{ paddingBottom: 0, paddingLeft: 0 }}
    onClear={() => onChange && onChange({ target: { value: "" } })}
    onChange={onChange}
    value={value}
  />
);

ReusableInput.propTypes = {
  label: PropTypes.string.isRequired,
  type: PropTypes.string,
  className: PropTypes.string,
  isRequired: PropTypes.bool,
  onChange: PropTypes.func,
  value: PropTypes.string,
};

export default ReusableInput;
