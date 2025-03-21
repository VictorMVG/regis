<?php
namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VisitsFilteredExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    /**
     * Retorna la colección de datos filtrados.
     */
    public function collection()
    {
        return $this->query->get();
    }

    /**
     * Define los encabezados de las columnas.
     */
    public function headings(): array
    {
        return [
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
    }

    /**
     * Mapea los datos de cada fila.
     */
    public function map($visit): array
    {
        return [
            $visit->created_at->format('d/m/Y'),
            $visit->created_at->format('h:i A'),
            $visit->exit_time ? $visit->exit_time->format('d/m/Y') : '',
            $visit->exit_time ? $visit->exit_time->format('h:i A') : '',
            $visit->headquarter->company->name . ' - ' . $visit->headquarter->name,
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
            $visit->user->email,
            $visit->exit_registered_by ? $visit->exitRegisteredBy->email : '',
        ];
    }

    /**
     * Aplica estilos al archivo Excel.
     */
    public function styles(Worksheet $sheet)
    {
        return [
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
                foreach (range('A', $event->sheet->getDelegate()->getHighestColumn()) as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}