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
            ['B001', 'barang1', 'SLSC', 'admin', 'Kamera', 'tersedia'],
            ['B002', 'barang2', 'SLC', 'admin', 'Kamera', 'tersedia'],
            ['B003', 'barang3', 'Lt. 6', 'admin', 'Kamera', 'tidak tersedia']
        ]);
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Spesifikasi Barang',
            'Lokasi Barang',
            'Pemilik Barang',
            'Kategori Barang',
            'Status Barang'
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
                $row_count = 10000;
                $column_count = 5;

                // set dropdown column for "Kategori Barang"
                $kategori_barang_drop_column = 'E'; // 'E' is the column index for the "Kategori Barang" column

                // set dropdown options for "Kategori Barang"
                $kategori_barang_options = AssetCategory::where('status', 1)->pluck('name')->toArray();

                // set dropdown list for first data row for "Kategori Barang"
                $kategori_barang_validation = $event->sheet->getCell("{$kategori_barang_drop_column}2")->getDataValidation();
                $kategori_barang_validation->setType(DataValidation::TYPE_LIST);
                $kategori_barang_validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $kategori_barang_validation->setAllowBlank(false);
                $kategori_barang_validation->setShowInputMessage(true);
                $kategori_barang_validation->setShowErrorMessage(true);
                $kategori_barang_validation->setShowDropDown(true);
                $kategori_barang_validation->setErrorTitle('Input error');
                $kategori_barang_validation->setError('Value is not in the list.');
                $kategori_barang_validation->setPromptTitle('Pick from the list');
                $kategori_barang_validation->setPrompt('Please pick a value from the drop-down list.');
                $kategori_barang_validation->setFormula1(sprintf('"%s"', implode(',', $kategori_barang_options)));

                // clone validation to remaining rows for "Kategori Barang"
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("{$kategori_barang_drop_column}{$i}")->setDataValidation(clone $kategori_barang_validation);
                }

                // set dropdown column for "Status Barang"
                $status_barang_drop_column = 'F'; // 'F' is the column index for the "Status Barang" column

                // set dropdown options for "Status Barang"
                $status_barang_options = ['tersedia', 'tidak tersedia'];

                // set dropdown list for first data row for "Status Barang"
                $status_barang_validation = $event->sheet->getCell("{$status_barang_drop_column}2")->getDataValidation();
                $status_barang_validation->setType(DataValidation::TYPE_LIST);
                $status_barang_validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $status_barang_validation->setAllowBlank(false);
                $status_barang_validation->setShowInputMessage(true);
                $status_barang_validation->setShowErrorMessage(true);
                $status_barang_validation->setShowDropDown(true);
                $status_barang_validation->setErrorTitle('Input error');
                $status_barang_validation->setError('Value is not in the list.');
                $status_barang_validation->setPromptTitle('Pick from the list');
                $status_barang_validation->setPrompt('Please pick a value from the drop-down list.');
                $status_barang_validation->setFormula1(sprintf('"%s"', implode(',', $status_barang_options)));

                // clone validation to remaining rows for "Status Barang"
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("{$status_barang_drop_column}{$i}")->setDataValidation(clone $status_barang_validation);
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

