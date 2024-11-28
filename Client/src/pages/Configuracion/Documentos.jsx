import { useMemo, useCallback, useState } from "react";
import Breadcrumb from "../../components/Breadcrumb/Breadcrumb";
import {
  Table, TableHeader, TableColumn, TableBody, TableRow, TableCell, Input, Button,
  DropdownTrigger, Dropdown, DropdownMenu, DropdownItem, Chip, Pagination, useDisclosure
} from "@nextui-org/react";
import { PlusIcon } from "../../components/Icons/PlusIcon";
import { VerticalDotsIcon } from "../../components/Icons/VerticalDotsIcon";
import { SearchIcon } from "../../components/Icons/SearchIcon";
import { ChevronDownIcon } from "../../components/Icons/ChevronDownIcon";
import { columns, statusOptions } from "../../Data/DataDocumentos.jsx";
import useDocumentos from "../../Data/DataDocumentos.jsx";
import { capitalize } from "../../services/utils.js";
import { MdSummarize } from "react-icons/md";
import Spinner from "../../components/Spinner/Spinner.jsx";
import Modal_New_Documento from "../../components/Modal/New/New_Documento.jsx";
import axios from "axios";
import { toast, Toaster } from "react-hot-toast";
import ModalConfirm from "../../components/Modal/Confirmation/ModalConfirm.jsx";
import Modal_Update_Documento from "../../components/Modal/Update/Update_Documento.jsx";

const statusColorMap = { 1: "success", 0: "danger" };
const INITIAL_VISIBLE_COLUMNS = ["nombre", "tipo", "fecha_vigencia", "fecha_fin", "estado", "accciones"];

export default function Documentos() {
  const { documentos, loading, fetchDocumentos } = useDocumentos();
  const { isOpen: isNewModalOpen, onOpen: onNewModalOpen, onOpenChange: onNewModalClose } = useDisclosure();
  const { isOpen: isUpdateModalOpen, onOpen: onUpdateModalOpen, onOpenChange: onUpdateModalClose } = useDisclosure();
  const [selectedDocument, setSelectedDocument] = useState(null);
  
  const [filterValue, setFilterValue] = useState("");
  const [selectedKeys, setSelectedKeys] = useState(new Set([]));
  const [visibleColumns, setVisibleColumns] = useState(new Set(INITIAL_VISIBLE_COLUMNS));
  const [statusFilter, setStatusFilter] = useState("all");
  const [rowsPerPage, setRowsPerPage] = useState(15);
  const [sortDescriptor, setSortDescriptor] = useState({ column: "name", direction: "ascending" });
  const [page, setPage] = useState(1);

  const [isConfirmModalOpen, setConfirmModalOpen] = useState(false);
  const [docToDelete, setDocToDelete] = useState(null);

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

  const openConfirmModal = (docId) => {
    setDocToDelete(docId);
    setConfirmModalOpen(true);
  };

  const closeConfirmModal = () => {
    setDocToDelete(null);
    setConfirmModalOpen(false);
  };

  const confirmDelete = async () => {
    if (!docToDelete) return;

    try {
      await axios.delete(`/documentos/${docToDelete}`);
      fetchDocumentos();
      setTimeout(() => toast.success("Documento eliminado correctamente."), 1000);;
    } catch (error) {
      setTimeout(() => toast.error("Error al eliminar el documento: " + (error.response?.data?.message || error.message)), 1000);
      
    } finally {
      closeConfirmModal();
    }
  };

  const openUpdateModal = useCallback((documento) => {
    setSelectedDocument(documento);
    onUpdateModalOpen();
  }, [onUpdateModalOpen]);

  const renderCell = useCallback((documento, columnKey) => {
  
    const cellValue = documento[columnKey];
    if (columnKey === "estado") {
      return (
        <Chip className="capitalize text-sm font-medium" color={statusColorMap[documento.estado]} size="sm" variant="flat">
          {cellValue === 1 ? "Activo" : "Inactivo"}
        </Chip>
      );
    } else if (columnKey === "accciones") {
      return (
        <div className="relative flex justify-center items-center gap-2">
          <Dropdown>
            <DropdownTrigger>
              <Button isIconOnly size="sm" variant="light">
                <VerticalDotsIcon className="text-default-300" />
              </Button>
            </DropdownTrigger>
            <DropdownMenu>
            <DropdownItem onPress={() => openUpdateModal(documento)}>Modificar</DropdownItem>
            <DropdownItem color="danger" onPress={() => openConfirmModal(documento.id)}>
                Eliminar
              </DropdownItem>
            </DropdownMenu>
          </Dropdown>
        </div>
      );
    }
    return <p className="font-medium capitalize text-sm text-default-500">{cellValue}</p>;
  }, [ openUpdateModal ]);

  const onRowsPerPageChange = useCallback((e) => { setRowsPerPage(Number(e.target.value)); setPage(1); }, []);
  const onSearchChange = useCallback((value) => { setFilterValue(value || ""); setPage(1); }, []);
  const onClear = useCallback(() => { setFilterValue(""); setPage(1); }, []);

  const topContent = useMemo(() => (
    <div className="flex flex-col gap-4">
      <div className="flex flex-col sm:flex-row justify-between gap-3 items-center flex-wrap">
        <Input
          isClearable
          className="w-full xl:max-w-[44%] focus:outline-none mt-3"
          placeholder="Buscar documento"
          startContent={<SearchIcon />}
          value={filterValue}
          onClear={onClear}
          onValueChange={onSearchChange}
        />
        <div className="flex gap-3 w-full sm:w-auto ml-auto justify-end">
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
              <DropdownTrigger className=" hidden md:flex">
                <Button
                  endContent={<ChevronDownIcon className="text-small" />}
                  variant="flat"
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
            className="w-full sm:w-auto" // Ajusta el ancho según lo necesario
            onPress={onNewModalOpen}
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
  ), [filterValue, onSearchChange, statusFilter, visibleColumns, onRowsPerPageChange, onClear, onNewModalOpen]);

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

      <Modal_New_Documento isOpen={isNewModalOpen} onClose={onNewModalClose} onDocumentCreated={fetchDocumentos} />
      <Modal_Update_Documento
    isOpen={isUpdateModalOpen}
    onClose={onUpdateModalClose}
    document={selectedDocument} // Pasa el documento seleccionado
    onDocumentUpdated={fetchDocumentos} // Refresca la lista al guardar
/>
      <ModalConfirm
        isOpen={isConfirmModalOpen}
        onClose={closeConfirmModal}
        onConfirm={confirmDelete}
        message="¿Estás seguro de que deseas eliminar este documento?"
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
