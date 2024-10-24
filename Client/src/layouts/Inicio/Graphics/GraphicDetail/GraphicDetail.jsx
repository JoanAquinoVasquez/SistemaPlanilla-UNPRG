import { FaDollarSign } from "react-icons/fa";
import { Card, CardHeader, CardBody } from "@nextui-org/react";
import PropTypes from "prop-types";

const CardComponent = ({
  bgColor,
  iconBgColor,
  textColor,
  title,
  amount,
  period,
}) => (
  <Card
    className={`w-[180px] sm:w-[210px] md:w-[210px] lg:w-[230px] xl:w-[280px]  ${bgColor} relative overflow-hidden rounded-lg shadow-md py-4`}
  >
    <div className={`absolute top-4 right-4 ${iconBgColor} p-2 rounded-md`}>
      <FaDollarSign size={21} color="#ffffff" />
    </div>
    <CardHeader className="pb-0 pt-4 px-4 flex-col items-start">
      <p className={`text-sm sm:text-sm md:text-md lg:text-md xl:text-xl uppercase font-bold ${textColor}`}>{title}</p>
    </CardHeader>
    <CardBody className="py-1 px-2 sm:py-1 sm:px-2 md:py-1 md:px-2 lg:py-1 lg:px-2 xl:py-2 xl:px-4">
      <h2 className="text-lg font-bold sm:text-lg md:text-xl lg:text-xl xl:text-3xl text-black">{amount}</h2>
      <p className="text-xs text-green-600 font-semibold sm:text-xs md:text-sm lg:text-sm xl:text-base" >{period}</p>
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
    <div className="bg-light flex flex-wrap justify-around pt-3">
      <div className="cards-docentes flex flex-wrap justify-center gap-4">
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
      <CardComponent
        bgColor="bg-[#f4f4fb]"
        iconBgColor="bg-[#7d76cf]"
        textColor="text-[#7d76cf]"
        title="Practicantes"
        amount="S/.5,405"
        period="Periodo 2024-I"
      />
    </div>
  </div>
  );
}
