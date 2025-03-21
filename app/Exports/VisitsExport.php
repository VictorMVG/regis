<?php

namespace App\Exports;

use App\Models\Visitas\Visita\Visit;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VisitsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    /**
     * Retorna la colección de datos a exportar.
     */

    protected $headings = [];
    protected $role;

    public function __construct()
    {
        $authUser = Auth::user();
        $this->role = $authUser->roles->first()->name;

        // Configurar encabezados según el rol
        if ($this->role == 'SUPER USUARIO' || $this->role == 'ADMINISTRADOR GENERAL') {
            $this->headings = [
                'FECHA DE INGRESO',
                'HORA DE INGRESO',
                'FECHA DE SALIDA',
                'HORA DE SALIDA',
                'SEDE',
                'NOMBRE DEL VISITANTE',
                'NOMBRE DE LA EMPRESA',
                'MOTIVO DE LA VISITA',
                'CON QUIEN SE DIRIGE',
                'PRUEBA DE ALCOHOL',
                '¿INGRESO CON VEHICULO?',
                'PLACAS',
                'MODELO',
                'NÚMERO ECONOMICO',
                'TIPO',
                'COLOR',
                'COMENTARIOS',
                'REGISTRÓ EL INGRESO',
                'REGISTRÓ LA SALIDA',
            ];
        } elseif ($this->role == 'ADMINISTRADOR DE SEDE') {
            $this->headings = [
                'FECHA DE INGRESO',
                'HORA DE INGRESO',
                'FECHA DE SALIDA',
                'HORA DE SALIDA',
                'NOMBRE DEL VISITANTE',
                'MOTIVO DE LA VISITA',
                'CON QUIEN SE DIRIGE',
                'PRUEBA DE ALCOHOL',
                '¿INGRESO CON VEHICULO?',
                'PLACAS',
                'MODELO',
                'NÚMERO ECONOMICO',
                'TIPO',
                'COLOR',
                'COMENTARIOS',
                'REGISTRÓ EL INGRESO',
                'REGISTRÓ LA SALIDA',
            ];
        } else {
            $this->headings = []; // Sin encabezados para roles no autorizados
        }
    }

    /**
     * Retorna la colección de datos a exportar.
     */
    public function collection()
    {
        $authUser = Auth::user();

        if ($this->role == 'SUPER USUARIO' || $this->role == 'ADMINISTRADOR GENERAL') {
            return Visit::whereDate('created_at', now())->get();
        } elseif ($this->role == 'ADMINISTRADOR DE SEDE') {
            return Visit::whereDate('created_at', now())->whereHas('headquarter.company', function ($query) use ($authUser) {
                $query->where('id', $authUser->company_id);
            })->get();
        } else {
            return Visit::whereRaw('1 = 0')->get();
        }
    }

    /**
     * Define los encabezados de las columnas.
     */
    public function headings(): array
    {
        return $this->headings;
    }

    /**
     * Mapea los datos de cada fila según el rol.
     */
    public function map($visit): array
    {
        if ($this->role == 'SUPER USUARIO' || $this->role == 'ADMINISTRADOR GENERAL') {
            return [
                $visit->created_at->format('d/m/Y'), // Fecha de ingreso
                $visit->created_at->format('h:i A'), // Hora de ingreso
                $visit->exit_time ? $visit->exit_time->format('d/m/Y') : '', // Fecha de salida
                $visit->exit_time ? $visit->exit_time->format('h:i A') : '', // Hora de salida
                $visit->headquarter->company->name . ' - ' .$visit->headquarter->name,
                $visit->visitor_name,
                $visit->company_name,
                $visit->reason,
                $visit->to_see,
                $visit->alcohol_test ? 'SI' : 'NO',
                $visit->unit ? 'SI' : 'NO',
                $visit->unit_plate,
                $visit->unit_model,
                $visit->unit_number,
                $visit->unitType ? $visit->unitType->name : '',
                $visit->unitColor ? $visit->unitColor->name : '',
                $visit->comment,
                // $visit->updatedBy ? $visit->updatedBy->name : '',
                $visit->user->email,
                $visit->exit_registered_by ? $visit->exitRegisteredBy->email : '',
            ];
        } elseif ($this->role == 'ADMINISTRADOR DE SEDE') {
            return [
                $visit->created_at->format('d/m/Y'), // Fecha de ingreso
                $visit->created_at->format('h:i A'), // Hora de ingreso
                $visit->exit_time ? $visit->exit_time->format('d/m/Y') : '', // Fecha de salida
                $visit->exit_time ? $visit->exit_time->format('h:i A') : '', // Hora de salida
                $visit->visitor_name,
                $visit->reason,
                $visit->to_see,
                $visit->alcohol_test ? 'SI' : 'NO',
                $visit->unit ? 'SI' : 'NO',
                $visit->unit_plate,
                $visit->unit_model,
                $visit->unit_number,
                $visit->unitType ? $visit->unitType->name : '',
                $visit->unitColor ? $visit->unitColor->name : '',
                $visit->comment,
                $visit->user->email,
                $visit->exit_registered_by ? $visit->exitRegisteredBy->email : '',
            ];
        } else {
            return [];
        }
    }

    /**
     * Aplica estilos al archivo Excel.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Aplica negritas a la primera fila (encabezados)
            1 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * Configura eventos para personalizar el archivo.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Ajustar automáticamente el ancho de las columnas
                foreach (range('A', $event->sheet->getDelegate()->getHighestColumn()) as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
