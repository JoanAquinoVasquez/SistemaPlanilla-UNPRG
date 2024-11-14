import { useMemo, useCallback, useState } from "react";
import Breadcrumb from "../../components/Breadcrumb/Breadcrumb";
import {
  Table, TableHeader, TableColumn, TableBody, TableRow, TableCell, Input, Button,
  DropdownTrigger, Dropdown, DropdownMenu, DropdownItem, Chip, Pagination, useDisclosure
} from "@nextui-org/react";
import { PlusIcon } from "../../components/Icons.jsx/PlusIcon";
import { VerticalDotsIcon } from "../../components/Icons.jsx/VerticalDotsIcon";
import { SearchIcon } from "../../components/Icons.jsx/SearchIcon";
import { ChevronDownIcon } from "../../components/Icons.jsx/ChevronDownIcon";
import { columns, statusOptions } from "../../data/DataDocumentos";
import useDocumentos from "../../data/DataDocumentos";
import { capitalize } from "./utils";
import { MdSummarize } from "react-icons/md";
import Spinner from "../../components/Spinner/Spinner.jsx";
import Modal_New_Documento from "../../components/Modal/New_Documento.jsx";
import axios from "axios";
import { toast, Toaster } from "react-hot-toast";

const statusColorMap = { 1: "success", 0: "danger" };
const INITIAL_VISIBLE_COLUMNS = ["nombre", "tipo", "fecha_vigencia", "fecha_fin", "estado", "accciones"];

export default function Documentos() {
  const { documentos, loading, fetchDocumentos } = useDocumentos();
  const { isOpen, onOpen, onOpenChange } = useDisclosure();
  const [filterValue, setFilterValue] = useState("");
  const [selectedKeys, setSelectedKeys] = useState(new Set([]));
  const [visibleColumns, setVisibleColumns] = useState(new Set(INITIAL_VISIBLE_COLUMNS));
  const [statusFilter, setStatusFilter] = useState("all");
  const [rowsPerPage, setRowsPerPage] = useState(15);
  const [sortDescriptor, setSortDescriptor] = useState({ column: "name", direction: "ascending" });
  const [page, setPage] = useState(1);

  const headerColumns = useMemo(() => visibleColumns === "all" ? columns : columns.filter(column => visibleColumns.has(column.uid)), [visibleColumns]);

  const filteredItems = useMemo(() => {
    let filtered = [...documentos];
    if (filterValue) filtered = filtered.filter(doc => doc.nombre.toLowerCase().includes(filterValue.toLowerCase()));
    if (statusFilter !== "all" && statusFilter.size !== statusOptions.length) filtered = filtered.filter(doc => statusFilter.has(doc.estado.toString()));
    return filtered;
  }, [filterValue, statusFilter, documentos]);

  const pages = Math.ceil(filteredItems.length / rowsPerPage);

  const items = useMemo(() => {
    const start = (page - 1) * rowsPerPage;
    return filteredItems.slice(start, start + rowsPerPage);
  }, [page, filteredItems, rowsPerPage]);

  const sortedItems = useMemo(() => {
    return [...items].sort((a, b) => {
      const cmp = a[sortDescriptor.column] < b[sortDescriptor.column] ? -1 : a[sortDescriptor.column] > b[sortDescriptor.column] ? 1 : 0;
      return sortDescriptor.direction === "descending" ? -cmp : cmp;
    });
  }, [sortDescriptor, items]);

  const renderCell = useCallback((documento, columnKey) => {
    const cellValue = documento[columnKey];
    if (columnKey === "estado") {
      return (
        <Chip className="capitalize text-sm font-medium" color={statusColorMap[documento.estado]} size="sm" variant="flat">
          {cellValue === 1 ? "Activo" : "Inactivo"}
        </Chip>
      );
    } else if (columnKey === "accciones") {
      const handleDelete = async (id) => {
        try {
          if (window.confirm("¿Estás seguro de que deseas eliminar este documento?")) {
            await axios.delete(`/documentos/${id}`);
            fetchDocumentos();
            setTimeout(() => toast.success("Documento eliminado correctamente."), 1000);
          }
        } catch (error) {
          toast.error("Error al eliminar el documento: " + (error.response?.data?.message || error.message));
        }
      };
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
              <DropdownItem color="danger" onPress={() => handleDelete(documento.id)}>
                Eliminar
              </DropdownItem>
            </DropdownMenu>
          </Dropdown>
        </div>
      );
    }
    return <p className="font-medium capitalize text-sm text-default-500">{cellValue}</p>;
  }, [fetchDocumentos]);

  const onRowsPerPageChange = useCallback((e) => { setRowsPerPage(Number(e.target.value)); setPage(1); }, []);
  const onSearchChange = useCallback((value) => { setFilterValue(value || ""); setPage(1); }, []);
  const onClear = useCallback(() => { setFilterValue(""); setPage(1); }, []);

const topContent = useMemo(() => (
  <div className="flex flex-col gap-4">
    <div className="flex flex-col sm:flex-row justify-between gap-3 items-center flex-wrap">
      <Input
        isClearable
        className="w-full xl:max-w-[44%] focus:outline-none"
        placeholder="Buscar documento"
        startContent={<SearchIcon />}
        value={filterValue}
        onClear={onClear}
        onValueChange={onSearchChange}
      />
      <div className="flex gap-3 w-full sm:w-auto ml-auto">
        {[
          {
            label: "Estado",
            options: statusOptions,
            selected: statusFilter,
            onChange: setStatusFilter,
          },
          {
            label: "Columnas",
            options: columns,
            selected: visibleColumns,
            onChange: setVisibleColumns,
          },
        ].map(({ label, options, selected, onChange }) => (
          <Dropdown key={label}>
            <DropdownTrigger className="w-full hidden md:flex">
              <Button
                endContent={<ChevronDownIcon className="text-small" />}
                variant="flat"
                className="w-full"
              >
                {label}
              </Button>
            </DropdownTrigger>
            <DropdownMenu
              disallowEmptySelection
              aria-label={label}
              closeOnSelect={false}
              selectedKeys={selected}
              selectionMode="multiple"
              onSelectionChange={onChange}
            >
              {options.map(({ uid, name }) => (
                <DropdownItem key={uid} className="capitalize">
                  {capitalize(name)}
                </DropdownItem>
              ))}
            </DropdownMenu>
          </Dropdown>
        ))}
        <Button
          color="primary"
          endContent={<PlusIcon />}
          className="w-full sm:w-auto"
          onPress={onOpen}
        >
          Nuevo
        </Button>
      </div>
    </div>
    <div className="flex justify-end items-center">
      <label className="flex items-center text-default-400 text-small">
        Filas por página:
        <select
          className="bg-transparent text-default-400 text-small ml-2"
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
), [filterValue, onSearchChange, statusFilter, visibleColumns, onRowsPerPageChange, onClear, onOpen]);

const bottomContent = useMemo(() => (
  <div className="py-2 px-2 flex justify-between items-center">
    <span className="w-[30%] text-small text-default-400" />
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
      {["Anterior", "Siguiente"].map((label, index) => {
        const isDisabled = (index === 0 && page === 1) || (index === 1 && page === pages);
        const handlePress = () => setPage((prevPage) => prevPage + (index === 0 ? -1 : 1));
        return (
          <Button
            key={label}
            isDisabled={isDisabled}
            size="sm"
            variant="flat"
            onPress={handlePress}
          >
            {label}
          </Button>
        );
      })}
    </div>
  </div>
), [page, pages]);

  if (loading) {
    return (
      <div className="loading-overlay">
        <Spinner label="Cargando Documentos..." />
      </div>
    );
  }

  return (
    <div>
      <Toaster position="top-right" reverseOrder={false} />
  
      <Modal_New_Documento
        isOpen={isOpen}
        onClose={onOpenChange}
        onDocumentCreated={fetchDocumentos}
      />
  
      <Breadcrumb paths={[{ name: "Documentos", href: "/configuracion/documentos" }]} />
  
      <div className="bg-white rounded-lg p-4 shadow-md mt-5">
        <p className="flex items-center text-xl font-medium text-800">
          <MdSummarize className="mr-2" />
          Relación de Documentos
        </p>
  
        <Table
          aria-label="Tabla de Documentos"
          layout="auto"
          isHeaderSticky
          bottomContent={bottomContent}
          bottomContentPlacement="outside"
          topContent={topContent}
          topContentPlacement="outside"
          classNames={{ wrapper: "max-h-[550px]" }}
          selectedKeys={selectedKeys}
          sortDescriptor={sortDescriptor}
          onSelectionChange={setSelectedKeys}
          onSortChange={setSortDescriptor}
        >
          <TableHeader columns={headerColumns}>
            {({ uid, name, sortable }) => (
              <TableColumn
                key={uid}
                align={uid === "acciones" ? "center" : "start"}
                allowsSorting={sortable}
              >
                {name}
              </TableColumn>
            )}
          </TableHeader>
          <TableBody items={sortedItems} emptyContent="No se encontraron documentos">
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
