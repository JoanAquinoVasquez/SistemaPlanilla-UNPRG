import { FaUsers } from "react-icons/fa";
import { Card, CardHeader, CardBody, Tooltip } from "@nextui-org/react";
import PropTypes from "prop-types";
import CountUp from "react-countup";
import { BsCashStack } from "react-icons/bs";
import useFormulas from "../../../../data/dataFormulas";

// CardComponent
const CardComponent = ({
  bgColor,
  iconBgColor,
  textColor,
  title,
  amount,
  period,
  isAmountCurrency = true,
  Icon = BsCashStack,
  tooltipDetails,
}) => {
  const formattedAmount = isAmountCurrency
    ? parseFloat(amount.replace("S/.", "").replace(",", ""))
    : parseInt(amount.replace(",", ""));

  return (
    <Tooltip
      placement="top"
      content={<div className="px-1 py-2">{tooltipDetails}</div>}
    >
      <Card
        className={`w-[180px] sm:w-[210px] md:w-[210px] lg:w-[240px] xl:w-[270px] ${bgColor} relative overflow-hidden rounded-lg shadow-md py-4`}
      >
        <div className={`absolute top-4 right-4 ${iconBgColor} p-2 rounded-md`}>
          <Icon size={21} color="#ffffff" />
        </div>
        <CardHeader className="pb-0 pt-4 px-4 flex-col items-start">
          <p
            className={`text-sm sm:text-sm md:text-md lg:text-md xl:text-xl uppercase font-bold ${textColor}`}
          >
            {title}
          </p>
        </CardHeader>
        <CardBody className="py-1 px-2 sm:py-1 sm:px-2 md:py-1 md:px-2 lg:py-1 lg:px-2 xl:py-2 xl:px-4">
          <h2 className="text-lg font-bold sm:text-lg md:text-xl lg:text-xl xl:text-3xl text-black">
            <CountUp
              start={0}
              end={formattedAmount}
              duration={2}
              separator=","
              prefix={isAmountCurrency ? "S/." : ""}
            />
          </h2>
          <p className="text-xs text-green-600 font-semibold sm:text-xs md:text-sm lg:text-sm xl:text-base">
            {period}
          </p>
        </CardBody>
      </Card>
    </Tooltip>
  );
};

CardComponent.propTypes = {
  bgColor: PropTypes.string.isRequired,
  iconBgColor: PropTypes.string.isRequired,
  textColor: PropTypes.string.isRequired,
  title: PropTypes.string.isRequired,
  amount: PropTypes.string.isRequired,
  period: PropTypes.string.isRequired,
  isAmountCurrency: PropTypes.bool,
  Icon: PropTypes.elementType,
  tooltipDetails: PropTypes.node,
};

// DocentesCard
const DocentesCard = () => {
  const { formulas, activeCount, inactiveCount } = useFormulas(); // Usar el hook
  const cardData = [
    {
      title: "Fórmulas",
      amount: `${formulas.length}`,
      period: "Formulas Registradas",
      bgColor: "bg-[#fdf1f4]",
      iconBgColor: "bg-[#a31b4f]",
      textColor: "text-[#a31b4f]",
      isAmountCurrency: false,
      Icon: FaUsers,
      tooltipDetails: (
        <>
          <div>Número total de fórmulas: {formulas.length}</div>
          <div>Activas: {activeCount}</div>
          <div>Inactivas: {inactiveCount}</div>
        </>
      ),
    },
    {
      title: "Docentes",
      amount: "S/.192,405",
      period: "Periodo 2024-I",
      bgColor: "bg-[#e5f3ff]",
      iconBgColor: "bg-[#3399ff]",
      textColor: "text-[#3399ff]",
      tooltipDetails: (
        <>
          <div>Total: 1,978 docentes</div>
          <div>Tiempo completo: 1,200</div>
          <div>Tiempo parcial: 778</div>
        </>
      ),
    },
    {
      title: "Administrativos",
      amount: "S/.92,405",
      period: "Periodo 2024-I",
      bgColor: "bg-[#f1fbfd]",
      iconBgColor: "bg-[#23c2d3]",
      textColor: "text-[#23c2d3]",
      tooltipDetails: "Información sobre el personal administrativo",
    },
    {
      title: "Pensionistas",
      amount: "S/.5,405",
      period: "Periodo 2024-I",
      bgColor: "bg-[#f4f4fb]",
      iconBgColor: "bg-[#7d76cf]",
      textColor: "text-[#7d76cf]",
      tooltipDetails: "Información sobre los pensionistas",
    },
    {
      title: "Practicantes",
      amount: "S/.5,405",
      period: "Periodo 2024-I",
      bgColor: "bg-[#f1fdf6]",
      iconBgColor: "bg-[#1ba322]",
      textColor: "text-[#1ba322]",
      tooltipDetails: "Información sobre los practicantes",
    },
    {
      title: "Personal",
      amount: "1,978",
      period: "Periodo 2024-I",
      bgColor: "bg-[#fdf1f4]",
      iconBgColor: "bg-[#a31b4f]",
      textColor: "text-[#a31b4f]",
      isAmountCurrency: false,
      Icon: FaUsers,
      tooltipDetails: "Información sobre el personal",
    },
  ];

  return (
    <div className="bg-light flex flex-wrap justify-around pt-3">
      <div className="cards-docentes flex flex-wrap justify-center gap-4">
        {cardData.map((card, index) => (
          <CardComponent key={index} {...card} />
        ))}
      </div>
    </div>
  );
};

export default DocentesCard;
