import { FaRegUser, FaMoneyBill } from "react-icons/fa";
import CustomCard from "../../../../components/Cards/Cards";

export default function GraphicSummary() {
  return (
    <div className="bg-white flex justify-center">
      <div className="cards-pensionistas flex flex-row gap-4">
        <CustomCard
          icon={<FaRegUser size={40} />}
          iconColor="text-purple-400"
          backgroundColor="#f4f4fb"
          title="Total del personal"
          value="1,256"
        />
        <CustomCard
          icon={<FaRegUser size={40} />}
          iconColor="text-yellow-400"
          backgroundColor="#fff4e5"
          title="Docentes Contratados"
          value="456"
        />
            <CustomCard
          icon={<FaMoneyBill size={40} />}
          iconColor="text-blue-400"
          backgroundColor="#f1f9fe"
          title="Docentes Contratados"
          value="456"
        />
        
      </div>
    </div>
  );
}
