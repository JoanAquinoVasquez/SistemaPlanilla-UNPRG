import { FaDollarSign } from "react-icons/fa";
import { Card, CardHeader, CardBody } from "@nextui-org/react";
import PropTypes from 'prop-types';

const CardComponent = ({ bgColor, iconBgColor, textColor ,title, amount, period }) => (
  <Card className={`w-[280px] ${bgColor} relative overflow-hidden rounded-lg shadow-md py-4`}>
    <div className={`absolute top-4 right-4 ${iconBgColor} p-2 rounded-md`}>
      <FaDollarSign size={21} color="#ffffff" />
    </div>
    <CardHeader className="pb-0 pt-4 px-4 flex-col items-start">
      <p className={`text-md uppercase font-bold ${textColor}`}>{title}</p>
    </CardHeader>
    <CardBody className="py-2 px-4">
      <h2 className="font-bold text-3xl text-black">{amount}</h2>
      <p className="text-green-600 font-semibold">{period}</p>
    </CardBody>
  </Card>
);

CardComponent.propTypes = {
  bgColor: PropTypes.string.isRequired,
  iconBgColor: PropTypes.string.isRequired,
  textColor: PropTypes.string.isRequired,
  title: PropTypes.string.isRequired,
  amount: PropTypes.string.isRequired,
  period: PropTypes.string.isRequired,
};
export default function DocentesCard() {
  return (
    <div className="bg-light flex justify-around pt-3">
      <div className="cards-docentes flex flex-row gap-4">
        <CardComponent
          bgColor="bg-[#e5f3ff]"
          iconBgColor="bg-[#3399ff]"
          textColor="text-[#3399ff]"
          title="Docentes"
          amount="S/.192,405"
          period="Periodo 2024-I"
        />
        <CardComponent
          bgColor="bg-[#f1fbfd]"
          iconBgColor="bg-[#23c2d3]"
          textColor="text-[#23c2d3]"
          title="Administrativos"
          amount="S/.92,405"
          period="Periodo 2024-I"
        />
        <CardComponent
          bgColor="bg-[#f4f4fb]"
          iconBgColor="bg-[#7d76cf]"
          textColor="text-[#7d76cf]"
          title="Pensionistas"
          amount="S/.5,405"
          period="Periodo 2024-I"
        />
        
      </div>
    </div>
  );
}
