import Breadcrumb from "../../components/Breadcrumb/Breadcrumb";

function Practicantes() {
  return (
    <div className=" ">
      <div>
        <Breadcrumb paths={[{ name: "Inicio", href: "/inicio" }, { name: 'Practicantes', href: '/practicantes' }]} />
      </div>
      
    </div>
  );
}

export default Practicantes;
