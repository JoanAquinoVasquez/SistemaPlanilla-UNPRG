import { useState, useMemo, useCallback, useEffect } from "react";
import {
  Dropdown,
  DropdownTrigger,
  DropdownMenu,
  DropdownItem,
  Button,
  Checkbox,
} from "@nextui-org/react";
import { FaFilter, FaUpload } from "react-icons/fa";
import {
  LineChart,
  Line,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  Legend,
  ResponsiveContainer,
} from "recharts";
import {
  salaryData,
  categories,
  categoryColors,
} from "../../../../Data/dataSalarios";

export default function GraphicSummary() {
  const [selectedCategories, setSelectedCategories] = useState([]);
  const [selectedSubcategory, setSelectedSubcategory] = useState("");
  const [isSumming, setIsSumming] = useState(false);

  useEffect(() => {
    // Cargar todas las categorías por defecto
    setSelectedCategories(Object.keys(categories));
  }, []);

  const handleCategoryChange = useCallback((category) => {
    setSelectedSubcategory("");
    setSelectedCategories((prev) =>
      prev.includes(category)
        ? prev.filter((cat) => cat !== category)
        : [...prev, category]
    );
  }, []);

  const handleSubcategoryChange = useCallback((key) => {
    setSelectedSubcategory(key);
  }, []);

  const combinedData = useMemo(() => {
    return salaryData.map((data) => {
      let combinedData = { date: data.date };
      selectedCategories.forEach((category) => {
        combinedData[category] = categories[category].reduce(
          (sum, subcat) => sum + (data[subcat] || 0),
          0
        );
      });
      return combinedData;
    });
  }, [selectedCategories]);


  return (
    <div className="bg-white flex" style={{ height: "max-content" }}>


      <div className="rounded-lg px-4  w-full" style={{ height: "max-content" }}>
        <div className="flex items-center justify-between mb-4">
          <p className="text-xl font-medium text-black">Salarios de Docentes</p>
          <div className="flex items-center justify-end">
            <Dropdown>
              <DropdownTrigger>
                <Button className="mr-3">
                  <FaFilter />
                </Button>
              </DropdownTrigger>
              <DropdownMenu
                aria-label="Category Selection"
                disallowEmptySelection
                selectionMode="multiple"
                selectedKeys={selectedCategories}
                onAction={handleCategoryChange}
              >
                {Object.keys(categories).map((category) => (
                  <DropdownItem key={category} withDivider>
                    <Checkbox
                      checked={selectedCategories.includes(category)}
                      onChange={() => handleCategoryChange(category)}
                      className="mr-2 rounded-lg"
                    />
                    {category}
                  </DropdownItem>
                ))}
              </DropdownMenu>
            </Dropdown>

            {selectedCategories.length === 1 && !isSumming && (
              <Dropdown className="ml-4">
                <DropdownTrigger>
                  <Button auto light>
                    {selectedSubcategory || "Seleccionar subcategoría"}
                  </Button>
                </DropdownTrigger>
                <DropdownMenu onAction={handleSubcategoryChange}>
                  {categories[selectedCategories[0]].map((subcat) => (
                    <DropdownItem key={subcat}>{subcat}</DropdownItem>
                  ))}
                </DropdownMenu>
              </Dropdown>
            )}
            <Button auto light className="ml-2">
              <FaUpload className="mr-2" />
              Exportar
            </Button>
          </div>
        </div>
        <div className="flex items-center justify-end">
          <Checkbox
            checked={isSumming}
            onChange={(e) => setIsSumming(e.target.checked)}
          />
          <label className="text-gray-600">Unir las categorías</label>
        </div>
        <ResponsiveContainer width="100%" height={440}>
          <LineChart
            data={isSumming ? combinedData : salaryData}
            margin={{ top: 20, right: 30, left: 20, bottom: 5 }}
          >
            <CartesianGrid strokeDasharray="3 3" />
            <XAxis dataKey="date" />
            <YAxis />
            <Tooltip
              formatter={(value) =>
                `S/.${new Intl.NumberFormat("es").format(value)}`
              }
            />
            <Legend />
            {isSumming ? (
              selectedCategories.map((category) => (
                <Line
                  key={category}
                  type="monotone"
                  dataKey={category}
                  name={category}
                  stroke={categoryColors[category]}
                  activeDot={{ r: 8 }}
                />
              ))
            ) : selectedCategories.length === 1 && selectedSubcategory ? (
              <Line
                type="monotone"
                dataKey={selectedSubcategory}
                stroke={categoryColors[selectedSubcategory]}
                activeDot={{ r: 8 }}
              />
            ) : (
              selectedCategories.flatMap((category) =>
                categories[category].map((subcat) => (
                  <Line
                    key={subcat}
                    type="monotone"
                    dataKey={subcat}
                    stroke={categoryColors[subcat]}
                    activeDot={{ r: 8 }}
                  />
                ))
              )
            )}
          </LineChart>
        </ResponsiveContainer>
      </div>
    </div>
  );
}
