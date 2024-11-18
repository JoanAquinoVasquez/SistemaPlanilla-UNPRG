import { useMemo, useCallback, useState } from "react";
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
  User,
  Pagination,
  useDisclosure,
} from "@nextui-org/react";
import { PlusIcon } from "../../components/Icons.jsx/PlusIcon";
import { VerticalDotsIcon } from "../../components/Icons.jsx/VerticalDotsIcon";
import { SearchIcon } from "../../components/Icons.jsx/SearchIcon";
import { ChevronDownIcon } from "../../components/Icons.jsx/ChevronDownIcon";
import { columns, statusOptions } from "../../data/DataPracticantes";
import usePracticantes from "../../data/DataPracticantes";
import { capitalize } from "./utils";
import Breadcrumb from "../../components/Breadcrumb/Breadcrumb";
import { MdSummarize } from "react-icons/md";
import Modal_New_Practicante from "../../components/Modal/New_Practicante";
import ExportarExcelButton from "../../components/ExportExcel/ExportarExcelButton";
import Spinner from "../../components/Spinner/Spinner.jsx";

const statusColorMap = { 1: "success", 0: "danger" };

const INITIAL_VISIBLE_COLUMNS = [
  "name",
  "tipo_doc_iden",
  "sub_tipo_empleado",
  "numerodecuenta",
  "unidad",
  "aporte",
  "estado",
  "accciones",
];

export default function Practicantes() {
  const { practicantes, loading, fetchPracticantes } = usePracticantes();
  const { isOpen, onOpen, onOpenChange } = useDisclosure();
  const [filterValue, setFilterValue] = useState("");
  const [selectedKeys, setSelectedKeys] = useState(new Set([]));
  const [visibleColumns, setVisibleColumns] = useState(
    new Set(INITIAL_VISIBLE_COLUMNS)
  );
  const [statusFilter, setStatusFilter] = useState("all");
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
    let filteredUsers = [...practicantes];
    if (filterValue) {
      filteredUsers = filteredUsers.filter(
        (user) =>
          user.name.toLowerCase().includes(filterValue.toLowerCase()) ||
          user.sub_tipo_empleado.toLowerCase().includes(filterValue.toLowerCase())
      );
    }
    if (statusFilter !== "all" && statusFilter.size !== statusOptions.length) filteredUsers = filteredUsers.filter(user => statusFilter.has(user.estado.toString()));

    return filteredUsers;
  }, [filterValue, statusFilter, practicantes]);

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

  const renderCell = useCallback((user, columnKey) => {
    const cellValue = user[columnKey];
    switch (columnKey) {
      case "name":
        return (
          <User
            description={user.email}
            name={cellValue}
            className="font-medium text-sm capitalize text-default-500"
          />
        );
      case "tipo_doc_iden":
        return (
          <div className="flex flex-col">
          <div className="font-medium capitalize text-sm text-default-500">
            {cellValue || "Sin asignar"}
          </div>
          <div className="text-sm text-default-400">
            {user.dni || "Sin asignar"}
          </div>
        </div>
        );
      case "numerodecuenta":
        return (
          <div className="flex flex-col">
            <div className="font-medium capitalize text-sm text-default-500">
              {cellValue || "Sin asignar"}
            </div>
            <div className="text-sm text-default-400">
              {"CCI: " + user.numerodecuenta || "Sin asignar"}
            </div>
          </div>
        );
      case "unidad":
        return (
          <div className="font-medium capitalize text-sm text-default-500" >
            {cellValue || "Sin asignar"}
          </div>
        );
      case "aporte":
        return (
          <div className="font-medium capitalize text-sm text-default-500" >
            {cellValue || "Sin asignar"}
          </div>
        );
      case "estado":
        return (
          <Chip className="capitalize text-sm font-medium" color={statusColorMap[user.estado]} size="sm" variant="flat">
            {cellValue === 1 ? "Activo" : "Inactivo"}
          </Chip>
        );
      case "sub_tipo_empleado":
        return (
          <div className="font-medium capitalize text-sm text-default-500">
            {cellValue || "Sin asignar"}
          </div>
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
            className="w-full xl:max-w-[44%] focus:outline-none "
            placeholder="Buscar al practicante "
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
                disallowEmptySelection
                aria-label="Table Columns"
                closeOnSelect={false}
                selectedKeys={statusFilter}
                selectionMode="multiple"
                onSelectionChange={setStatusFilter}
              >
                {statusOptions.map((status) => (
                  <DropdownItem key={status.uid} className="capitalize">
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
              onPress={onOpen}
            >
              Nuevo
            </Button>
            <ExportarExcelButton />

          </div>
        </div>
        <div className="flex justify-between items-center">
          <span className="text-default-400 text-small">
            Total: {practicantes.length} practicantes
          </span>
          <label className="flex items-center text-default-400 text-small">
            Filas por página:
            <select
              className="bg-transparent text-default-400 text-small"
              onChange={onRowsPerPageChange}
            >
              {[15, 10, 5].map((option) => (
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
      onOpen,
      practicantes.length,
    ]
  );

  const bottomContent = useMemo(
    () => (
      <div className="py-2 px-2 flex justify-between items-center">
        <span className="w-[30%] text-small text-default-400">
          {selectedKeys === "all"
            ? "All items selected"
            : `${selectedKeys.size} de ${filteredItems.length} seleccionados`}
        </span>
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
            isDisabled={page === 1} // Deshabilitar si está en la primera página
            size="sm"
            variant="flat"
            onPress={() => {
              if (page > 1) setPage(page - 1);
            }}
          >
            Anterior
          </Button>
          <Button
            isDisabled={page === pages} // Deshabilitar si está en la última página
            size="sm"
            variant="flat"
            onPress={() => {
              if (page < pages) setPage(page + 1);
            }}
          >
            Siguiente
          </Button>
        </div>
      </div>
    ),
    [selectedKeys, filteredItems.length, page, pages]
  );

  if (loading) {
    return (
      <div className="loading-overlay">
        <Spinner label="Cargando Practicantes..." />
      </div>
    );
  }

  return (
    <div>
      <Modal_New_Practicante isOpen={isOpen} onClose={onOpenChange} />
      <Breadcrumb
        paths={[
          { name: "Inicio", href: "/inicio" },
          { name: "Personal", href: "/personal" },
          { name: "Practicantes", href: "/personal/practicantes" },
        ]}
      />
      <div className="bg-white rounded-lg p-4 shadow-md mt-5">
        <p className="flex items-center text-xl font-medium text-800">
          <MdSummarize className="mr-2" />
          Relación de Practicantes
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
          selectionMode="multiple"
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
                align={column.uid === "accciones" ? "center" : "start"}
                allowsSorting={column.sortable}
              >
                {column.name}
              </TableColumn>
            )}
          </TableHeader>
          <TableBody
            emptyContent={"No se encontraron usuarios"}
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
