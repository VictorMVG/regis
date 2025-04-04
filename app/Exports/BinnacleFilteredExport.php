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
            'TÍTULO',
            'OBSERVACIÓN',
            'TIPO DE OBSERVACIÓN',
            'USUARIO',
            'SEDE',
            'ACTUALIZADO POR',
        ];
    }

    public function map($binnacle): array
    {
        return [
            $binnacle->created_at->format('d/m/Y'),
            $binnacle->title,
            $binnacle->observation,
            $binnacle->observationType->name,
            $binnacle->user->name,
            $binnacle->headquarter->company->name . ' - ' . $binnacle->headquarter->name,
            $binnacle->updatedBy ? $binnacle->updatedBy->name : '',
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
