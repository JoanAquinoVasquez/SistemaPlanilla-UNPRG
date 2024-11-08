import { useMemo, useCallback, useState } from "react";
import Breadcrumb from "../../components/Breadcrumb/Breadcrumb";
import {
  Table,
  TableHeader,
  TableColumn,
  TableBody,
  TableRow,
  TableCell,
  Input,
  Button,
  DropdownTrigger,
  Dropdown,
  DropdownMenu,
  DropdownItem,
  Chip,
  Pagination,
} from "@nextui-org/react";
import { PlusIcon } from "../../components/Icons.jsx/PlusIcon";
import { VerticalDotsIcon } from "../../components/Icons.jsx/VerticalDotsIcon";
import { SearchIcon } from "../../components/Icons.jsx/SearchIcon";
import { ChevronDownIcon } from "../../components/Icons.jsx/ChevronDownIcon";
import { columns, statusOptions } from "../../Data/DataDocumentos";
import useDocumentos from "../../Data/DataDocumentos";
import { capitalize } from "./utils";
import { MdSummarize } from "react-icons/md";
import Spinner from "../../components/Spinner/Spinner.jsx"; // Importa el componente Spinner

const statusColorMap = {
  1: "success",
  0: "danger",
};

const INITIAL_VISIBLE_COLUMNS = [
  "nombre",
  "tipo",
  "fecha_vigencia",
  "fecha_fin",
  "estado",
  "accciones",
];

export default function Documentos() {
  const { documentos, loading } = useDocumentos(); // Obtén el estado de carga desde el hook

  const [filterValue, setFilterValue] = useState("");
  const [selectedKeys, setSelectedKeys] = useState(new Set([]));
  const [visibleColumns, setVisibleColumns] = useState(
    new Set(INITIAL_VISIBLE_COLUMNS)
  );
  const [statusFilter, setStatusFilter] = useState(new Set([]));
  const [rowsPerPage, setRowsPerPage] = useState(15);
  const [sortDescriptor, setSortDescriptor] = useState({
    column: "name",
    direction: "ascending",
  });
  const [page, setPage] = useState(1);

  const headerColumns = useMemo(() => {
    return visibleColumns === "all"
      ? columns
      : columns.filter((column) => visibleColumns.has(column.uid));
  }, [visibleColumns]);

  const filteredItems = useMemo(() => {
    let filteredDocumentos = [...documentos];

    if (filterValue) {
      filteredDocumentos = filteredDocumentos.filter((doc) =>
        doc.nombre.toLowerCase().includes(filterValue.toLowerCase())
      );
    }

    if (statusFilter.size > 0) {
      filteredDocumentos = filteredDocumentos.filter((doc) =>
        statusFilter.has(doc.estado)
      );
    }

    return filteredDocumentos;
  }, [filterValue, statusFilter, documentos]);

  const toggleStatusFilter = (key) => {
    setStatusFilter((prevFilter) => {
      const newFilter = new Set(prevFilter);
      const numKey = Number(key);
      if (newFilter.has(numKey)) {
        newFilter.delete(numKey); // Si el estado ya está, lo eliminamos
      } else {
        newFilter.add(numKey); // Si no está, lo agregamos
      }
      return newFilter;
    });
  };
  const pages = Math.ceil(filteredItems.length / rowsPerPage);

  const items = useMemo(() => {
    const start = (page - 1) * rowsPerPage;
    return filteredItems.slice(start, start + rowsPerPage);
  }, [page, filteredItems, rowsPerPage]);

  const sortedItems = useMemo(() => {
    return [...items].sort((a, b) => {
      const first = a[sortDescriptor.column];
      const second = b[sortDescriptor.column];
      const cmp = first < second ? -1 : first > second ? 1 : 0;
      return sortDescriptor.direction === "descending" ? -cmp : cmp;
    });
  }, [sortDescriptor, items]);

  const renderCell = useCallback((documento, columnKey) => {
    const cellValue = documento[columnKey];
    switch (columnKey) {
      case "estado":
        return (
          <Chip
            className="capitalize text-sm font-medium"
            color={statusColorMap[documento.estado]}
            size="sm"
            variant="flat"
          >
            {cellValue === 1 ? "Activo" : "Inactivo"}
          </Chip>
        );

      case "accciones":
        return (
          <div className="relative flex justify-center items-center gap-2">
            <Dropdown>
              <DropdownTrigger>
                <Button isIconOnly size="sm" variant="light">
                  <VerticalDotsIcon className="text-default-300" />
                </Button>
              </DropdownTrigger>
              <DropdownMenu>
                <DropdownItem>Modificar</DropdownItem>
                <DropdownItem>Eliminar</DropdownItem>
              </DropdownMenu>
            </Dropdown>
          </div>
        );
      default:
        return (
          <p className="font-medium capitalize text-sm text-default-500">
            {cellValue}
          </p>
        );
    }
  }, []);

  const onRowsPerPageChange = useCallback((e) => {
    setRowsPerPage(Number(e.target.value));
    setPage(1);
  }, []);

  const onSearchChange = useCallback((value) => {
    setFilterValue(value || "");
    setPage(1);
  }, []);

  const onClear = useCallback(() => {
    setFilterValue("");
    setPage(1);
  }, []);

  const topContent = useMemo(
    () => (
      <div className="flex flex-col gap-4">
        <div className="flex flex-col sm:flex-row justify-between gap-3 items-end sm:items-center flex-wrap">
          <Input
            isClearable
            className="w-full xl:max-w-[44%] focus:outline-none"
            placeholder="Buscar documento"
            startContent={<SearchIcon />}
            value={filterValue}
            onClear={onClear}
            onValueChange={onSearchChange}
          />
          <div className="flex sm:flex-row gap-3 w-full sm:w-auto ml-auto">
            <Dropdown>
              <DropdownTrigger className="w-full sm:w-auto hidden md:flex lg:flex xl:flex">
                <Button
                  endContent={<ChevronDownIcon className="text-small" />}
                  variant="flat"
                  className="w-full sm:w-auto"
                >
                  Estado
                </Button>
              </DropdownTrigger>
              <DropdownMenu
                selectionMode="multiple"
                closeOnSelect={false}
                aria-label="Filtro de estado"
              >
                {statusOptions.map((status) => (
                  <DropdownItem
                    key={status.uid}
                    className="capitalize"
                    onClick={() => toggleStatusFilter(status.uid)}
                    selected={statusFilter.has(status.uid)} // Aseguramos que muestre el estado seleccionado
                  >
                    {capitalize(status.name)}
                  </DropdownItem>
                ))}
              </DropdownMenu>
            </Dropdown>

            <Dropdown>
              <DropdownTrigger className="w-full hidden md:flex lg:flex xl:flex">
                <Button
                  endContent={<ChevronDownIcon className="text-small" />}
                  variant="flat"
                  className="w-full sm:w-auto"
                >
                  Columnas
                </Button>
              </DropdownTrigger>
              <DropdownMenu
                disallowEmptySelection
                aria-label="Table Columns"
                closeOnSelect={false}
                selectedKeys={visibleColumns}
                selectionMode="multiple"
                onSelectionChange={setVisibleColumns}
              >
                {columns.map((column) => (
                  <DropdownItem key={column.uid} className="capitalize">
                    {capitalize(column.name)}
                  </DropdownItem>
                ))}
              </DropdownMenu>
            </Dropdown>

            <Button
              color="primary"
              endContent={<PlusIcon />}
              className="w-full sm:w-auto"
            >
              Nuevo
            </Button>
          </div>
        </div>
        <div className="flex justify-end items-center">
          <label className="flex items-center text-default-400 text-small">
            Filas por página:
            <select
              className="bg-transparent text-default-400 text-small"
              onChange={onRowsPerPageChange}
            >
              {[5, 10, 15].map((option) => (
                <option key={option} value={option}>
                  {option}
                </option>
              ))}
            </select>
          </label>
        </div>
      </div>
    ),
    [
      filterValue,
      onSearchChange,
      statusFilter,
      visibleColumns,
      onRowsPerPageChange,
      onClear,
    ]
  );

  const bottomContent = useMemo(
    () => (
      <div className="py-2 px-2 flex justify-between items-center">
        <span className="w-[30%] text-small text-default-400"></span>
        <Pagination
          isCompact
          showControls
          showShadow
          color="primary"
          page={page}
          total={pages}
          onChange={setPage}
        />
        <div className="hidden sm:flex w-[30%] justify-end gap-2">
          <Button
            isDisabled={pages === 1}
            size="sm"
            variant="flat"
            onPress={() => setPage(page - 1)}
          >
            Anterior
          </Button>
          <Button
            isDisabled={pages === 1}
            size="sm"
            variant="flat"
            onPress={() => setPage(page + 1)}
          >
            Siguiente
          </Button>
        </div>
      </div>
    ),
    [page, pages]
  );

  
  if (loading) {
    return (
      <div className="loading-overlay">
        <Spinner label="Cargando Documentos..." />
      </div>
    );
  }

  return (
    <div>
      <Breadcrumb
        paths={[{ name: "Documentos", href: "/configuracion/documentos" }]}
      />
      <div className="bg-white rounded-lg p-4 shadow-md mt-5">
        <p className="flex items-center text-xl font-medium text-800">
          <MdSummarize className="mr-2" />
          Relación de Documentos
        </p>
        <div className="mt-4"></div>
        <Table
          aria-label="Example table"
          layout="auto"
          isHeaderSticky
          bottomContent={bottomContent}
          bottomContentPlacement="outside"
          classNames={{ wrapper: "max-h-[550px]" }}
          selectedKeys={selectedKeys}
          sortDescriptor={sortDescriptor}
          topContent={topContent}
          topContentPlacement="outside"
          onSelectionChange={setSelectedKeys}
          onSortChange={setSortDescriptor}
        >
          <TableHeader columns={headerColumns}>
            {(column) => (
              <TableColumn
                key={column.uid}
                align={column.uid === "acciones" ? "center" : "start"}
                allowsSorting={column.sortable}
              >
                {column.name}
              </TableColumn>
            )}
          </TableHeader>
          <TableBody
            emptyContent={"No se encontraron documentos"}
            items={sortedItems}
          >
            {(item) => (
              <TableRow key={item.id}>
                {(columnKey) => (
                  <TableCell>{renderCell(item, columnKey)}</TableCell>
                )}
              </TableRow>
            )}
          </TableBody>
        </Table>
      </div>
    </div>
  );
}
