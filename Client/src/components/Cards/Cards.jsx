import PropTypes from 'prop-types';

const CustomCard = ({ icon, iconColor, backgroundColor, title, value }) => {
  return (
    <div className="shadow-md rounded-lg px-4 py-4" style={{ background: backgroundColor }}>
      <div className={`pb-0 px-4 flex-col items-start ${iconColor}`}>
        {icon}
      </div>
      <div className="overflow-visible py-2">
        <p className="text-xs uppercase font-semibold text-gray-600">
          {title}
        </p>
        <h4 className="font-bold text-xl text-gray-800">{value}</h4>
      </div>
    </div>
  );
};

CustomCard.propTypes = {
  icon: PropTypes.element.isRequired,
  iconColor: PropTypes.string.isRequired,
  backgroundColor: PropTypes.string.isRequired,
  title: PropTypes.string.isRequired,
  value: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
};

export default CustomCard;
