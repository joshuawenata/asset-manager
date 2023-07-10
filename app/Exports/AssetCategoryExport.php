<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\AssetCategory;

class AssetCategoryExport implements FromCollection, WithHeadings, WithStyles, WithEvents, ShouldAutoSize, WithTitle, WithStrictNullComparison
{
    public function collection()
    {
        return new Collection([
            ['B001', 'barang1', 'SLSC', 'admin', 'Kamera'],
            ['B002', 'barang2', 'SLC', 'admin', 'Kamera'],
            ['B003', 'barang3', 'Lt. 6', 'admin', 'Kamera']
        ]);
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Spesifikasi Barang',
            'Lokasi Barang',
            'Pemilik Barang',
            'Kategori Barang'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            '2:' . $sheet->getHighestRow() => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ],
        ];
    }

    public function title(): string
    {
        return 'List Barang';
    }

    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {

                // get layout counts (add 1 to rows for heading row)
                $row_count = 1000;
                $column_count = 5;

                // set dropdown column
                $drop_column = 'E';

                // set dropdown options
                $options = AssetCategory::where('status', 1)->pluck('name')->toArray();

                // set dropdown list for first data row
                $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST );
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input error');
                $validation->setError('Value is not in list.');
                $validation->setPromptTitle('Pick from list');
                $validation->setPrompt('Please pick a value from the drop-down list.');
                $validation->setFormula1(sprintf('"%s"',implode(',',$options)));

                // clone validation to remaining rows
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                }

                // set columns to autosize
                for ($i = 1; $i <= $column_count; $i++) {
                    $column = Coordinate::stringFromColumnIndex($i);
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }

}

