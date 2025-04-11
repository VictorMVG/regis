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

class BinnacleFilteredExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function collection()
    {
        return $this->query->get();
    }

    public function headings(): array
    {
        return [
            'FECHA',
            'SEDE',
            'TÍTULO DE LA OBSERVACIÓN',
            'TIPO DE OBSERVACIÓN',
            'QUIEN CREO EL REGISTRO',
            'OBSERVACIÓN',
            'ULTIMO QUE LO ACTUALIZÓ',
        ];
    }

    public function map($binnacle): array
    {
        return [
            $binnacle->created_at->format('d/m/Y'), // Fecha de creación
            $binnacle->headquarter->company->name . ' - ' . $binnacle->headquarter->name, // Sede
            $binnacle->title, // Título
            $binnacle->observationType->name, // Tipo de observación
            $binnacle->user->name, // Usuario que creó la bitácora
            $binnacle->observation, // Observación
            $binnacle->updatedBy ? $binnacle->updatedBy->name : '', // Usuario que actualizó
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

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
