<?php

namespace App\Exports;

use App\Models\Bitacoras\Bitacora\Binnacle;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BinnaclesTodayExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $headings = [];
    protected $role;

    public function __construct()
    {
        $authUser = Auth::user();
        $this->role = $authUser->roles->first()->name;

        // Configurar encabezados según el rol
        $this->headings = [
            'FECHA',
            'SEDE',
            'TÍTULO DE LA OBSERVACIÓN',
            'TIPO DE OBSERVACIÓN',
            'QUIEN CREO EL REGISTRO',
            'OBSERVACIÓN',
            'ULTIMO QUE LO ACTUALIZÓ',
        ];
    }

    /**
     * Retorna la colección de datos a exportar.
     */
    public function collection()
    {
        $authUser = Auth::user();

        // Filtrar registros según el rol del usuario y pre-cargar relaciones
        if ($this->role == 'SUPER USUARIO' || $this->role == 'ADMINISTRADOR GENERAL') {
            return Binnacle::with(['user', 'headquarter.company', 'observationType', 'updatedBy'])
                ->whereDate('created_at', now())
                ->get();
        } elseif ($this->role == 'ADMINISTRADOR DE SEDE') {
            return Binnacle::with(['user', 'headquarter.company', 'observationType', 'updatedBy'])
                ->whereDate('created_at', now())
                ->whereHas('headquarter.company', function ($query) use ($authUser) {
                    $query->where('id', $authUser->company_id);
                })
                ->get();
        } elseif ($this->role == 'GUARDIA') {
            return Binnacle::with(['user', 'headquarter.company', 'observationType', 'updatedBy'])
                ->whereDate('created_at', now())
                ->where('headquarter_id', $authUser->headquarter_id)
                ->get();
        } else {
            return Binnacle::whereRaw('1 = 0')->get(); // Retorna una colección vacía si no tiene permisos
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
     * Mapea los datos de cada fila.
     */
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

    /**
     * Aplica estilos al archivo Excel.
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Aplica negritas a la primera fila (encabezados)
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
