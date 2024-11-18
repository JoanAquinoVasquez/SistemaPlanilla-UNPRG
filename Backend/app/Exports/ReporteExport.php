<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class ReporteExport implements FromCollection, WithHeadings
{
    protected $empleadoTipos;

    public function __construct($empleadoTipos)
    {
        $this->empleadoTipos = $empleadoTipos;
    }

    public function collection()
    {
        return $this->empleadoTipos->map(function ($empleadoTipo) {
            return [
                'Tipo Documento' => $empleadoTipo->empleado->tipo_doc_iden,
                'Número de Documento' => $empleadoTipo->empleado_num_doc_iden,
                'Apellido Paterno' => $empleadoTipo->empleado->apellido_paterno,
                'Apellido Materno' => $empleadoTipo->empleado->apellido_materno,
                'Nombre' => $empleadoTipo->empleado->nombres,
                'Area Loboral Actual' => $empleadoTipo->areaActiva->area->nombre,
                'Oficina' => $empleadoTipo->areaActiva?->area?->oficina,
                'Unidad' => $empleadoTipo->areaActiva?->area?->unidad,
                'Facultad' => $empleadoTipo->areaActiva?->area?->facultad,
                'Escuela' => $empleadoTipo->areaActiva?->area?->escuela,

                'Tipo Empleado' => $empleadoTipo->tipoEmpleado->nombre,
                'Sub Tipo Empleado' => $empleadoTipo->subTipoEmpleado->nombre,

                /* 'Fecha de Nacimiento' => $empleadoTipo->empleado->fecha_nacimiento,
                'Sexo' => $empleadoTipo->empleado->sexo,
                'Estado Civil' => $empleadoTipo->empleado->estado_civil,
                'Dirección' => $empleadoTipo->empleado->direccion,
                'Teléfono' => $empleadoTipo->empleado->telefono,
                'Email' => $empleadoTipo->empleado->email, */

                'Banco' => $empleadoTipo->banco->nombre,
                'Tipo de Cuenta' => $empleadoTipo->tipo_cuenta,
                'CCI' => $empleadoTipo->cci,
                'Número de Cuenta' => $empleadoTipo->numero_cuenta,
                'Estado' => $empleadoTipo->estado ? 'Activo' : 'Inactivo',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tipo Documento',
            'Número de Documento',
            'Apellido Paterno',
            'Apellido Materno',
            'Nombre',
            'Area Loboral Actual',
            'Oficina',
            'Unidad',
            'Facultad',
            'Escuela',
            'Tipo Empleado',
            'Sub Tipo Empleado',
            /* 'Fecha de Nacimiento',
            'Sexo',
            'Estado Civil',
            'Dirección',
            'Teléfono',
            'Email', */
            'Banco',
            'Tipo de Cuenta',
            'CCI',
            'Número de Cuenta',
            'Estado',
        ];
    }


    /*     public function styles(Worksheet $sheet)
    {
        return [
            // Aplica el color de fondo y estilo a la fila de encabezado (primera fila)
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4CAF50'] // Color verde
                ],
            ],
        ];
    } */
}
