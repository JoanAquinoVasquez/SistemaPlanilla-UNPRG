import PropTypes from "prop-types";
import { FaEye, FaEyeSlash } from "react-icons/fa";

function InputField({
    divContainerStyle,
    type,
    value,
    setValue,
    placeholder,
    label,
    showToggle = false,
    showPassword,
    togglePasswordVisibility,
    classNameInputField,
    classNameLabel,
    classNameShowToggle,
}) {
    return (
        <div className={divContainerStyle}>
            <input
                type={type}
                value={value}
                onChange={(e) => setValue(e.target.value)}
                className={classNameInputField}
                placeholder={placeholder}
            />
            {label && <label className={classNameLabel}>{label}</label>}
            {showToggle && (
                <div className={classNameShowToggle} onClick={togglePasswordVisibility}>
                    {showPassword ? <FaEyeSlash /> : <FaEye />}
                </div>
            )}
        </div>
    );
}

InputField.propTypes = {
    divContainerStyle: PropTypes.string,
    type: PropTypes.string.isRequired,
    value: PropTypes.string.isRequired,
    setValue: PropTypes.func.isRequired,
    placeholder: PropTypes.string,
    label: PropTypes.string,
    showToggle: PropTypes.bool,
    showPassword: PropTypes.bool,
    togglePasswordVisibility: PropTypes.func,
    classNameInputField: PropTypes.string,
    classNameLabel: PropTypes.string,
    classNameShowToggle: PropTypes.string,
};

export default InputField;
