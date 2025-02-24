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
use Illuminate\Support\Facades\Auth;
use App\Models\AssetJenis;
use App\Models\Location;
use App\Models\PemilikBarang;

class AssetJenisExport implements FromCollection, WithHeadings, WithStyles, WithEvents, ShouldAutoSize, WithTitle, WithStrictNullComparison
{
    public function collection()
    {
        $userDivisionId = Auth::user()->division_id;
        $location_options = Location::pluck('name')->toArray();
        $pemilik_barang_options = PemilikBarang::where('division_id', $userDivisionId)->pluck('nama')->toArray();
        $kategori_barang_options = AssetJenis::where('status', 1)->pluck('name')->toArray();

        if (empty($location_options)) {
            throw new \Exception('Location options are empty.');
        }

        if (empty($pemilik_barang_options)) {
            throw new \Exception('Pemilik Barang options are empty.');
        }

        if (empty($kategori_barang_options)) {
            throw new \Exception('Kategori Barang options are empty.');
        }

        return new Collection([
            ['PCS001001', $location_options[0], $pemilik_barang_options[0], $kategori_barang_options[0], 'Projector', 'HP', 'HP ABC', 'tersedia'],
            ['DKV001002', $location_options[0], $pemilik_barang_options[0], $kategori_barang_options[0], 'Projector', 'HP', 'HP DEF', 'tersedia'],
            ['PCP001003', $location_options[0], $pemilik_barang_options[0], $kategori_barang_options[0], 'Projector', 'HP', 'HP GHI', 'tidak']
        ]);
    }

    public function headings(): array
    {
        return [
            'Kode Barang',
            'Lokasi Barang',
            'Pemilik Barang',
            'Jenis Barang',
            'Kategori Barang',
            'Spesifikasi Barang',
            'Brand',
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
            AfterSheet::class => function (AfterSheet $event) {

                // get layout counts (add 1 to rows for heading row)
                $row_count = 10000;
                $column_count = 5;

                $location_drop_column = 'B'; // 'B' is the column index for the "Location" column
    
                // Fetch dropdown options for "Location" from the "AssetLocation" table
                $location_options = Location::pluck('name')->toArray();

                // set dropdown list for first data row for "Location"
                $location_validation = $event->sheet->getCell("{$location_drop_column}2")->getDataValidation();
                $location_validation->setType(DataValidation::TYPE_LIST);
                // $location_validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $location_validation->setAllowBlank(true);
                // $location_validation->setShowInputMessage(true);
                // $location_validation->setShowErrorMessage(true);
                $location_validation->setShowDropDown(true);
                // $location_validation->setErrorTitle('Input error');
                // $location_validation->setError('Value is not in the list.');
                // $location_validation->setPromptTitle('Pick from the list');
                // $location_validation->setPrompt('Please pick a value from the drop-down list.');
                $location_validation->setFormula1(sprintf('"%s"', implode(',', $location_options)));

                // clone validation to remaining rows for "Location"
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("{$location_drop_column}{$i}")->setDataValidation(clone $location_validation);
                }

                $pemilik_barang_drop_column = 'C'; // 'D' is the column index for the "Pemilik Barang" column
    
                // Fetch dropdown options for "Pemilik Barang" based on the logged-in user's division ID
                $userDivisionId = Auth::user()->division_id; // Assuming you have a user authentication system
                $pemilik_barang_options = PemilikBarang::where('division_id', $userDivisionId)->pluck('nama')->toArray();

                // set dropdown list for first data row for "Pemilik Barang"
                $pemilik_barang_validation = $event->sheet->getCell("{$pemilik_barang_drop_column}2")->getDataValidation();
                $pemilik_barang_validation->setType(DataValidation::TYPE_LIST);
                // $pemilik_barang_validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $pemilik_barang_validation->setAllowBlank(true);
                // $pemilik_barang_validation->setShowInputMessage(true);
                // $pemilik_barang_validation->setShowErrorMessage(true);
                $pemilik_barang_validation->setShowDropDown(true);
                // $pemilik_barang_validation->setErrorTitle('Input error');
                // $pemilik_barang_validation->setError('Value is not in the list.');
                // $pemilik_barang_validation->setPromptTitle('Pick from the list');
                // $pemilik_barang_validation->setPrompt('Please pick a value from the drop-down list.');
                $pemilik_barang_validation->setFormula1(sprintf('"%s"', implode(',', $pemilik_barang_options)));

                // clone validation to remaining rows for "Pemilik Barang"
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("{$pemilik_barang_drop_column}{$i}")->setDataValidation(clone $pemilik_barang_validation);
                }

                // set dropdown column for "Kategori Barang"
                $kategori_barang_drop_column = 'D'; // 'E' is the column index for the "Kategori Barang" column
    
                // set dropdown options for "Kategori Barang"
                $kategori_barang_options = AssetJenis::where('status', 1)->pluck('name')->toArray();

                // set dropdown list for first data row for "Kategori Barang"
                $kategori_barang_validation = $event->sheet->getCell("{$kategori_barang_drop_column}2")->getDataValidation();
                $kategori_barang_validation->setType(DataValidation::TYPE_LIST);
                // $kategori_barang_validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $kategori_barang_validation->setAllowBlank(true);
                // $kategori_barang_validation->setShowInputMessage(true);
                // $kategori_barang_validation->setShowErrorMessage(true);
                $kategori_barang_validation->setShowDropDown(true);
                // $kategori_barang_validation->setErrorTitle('Input error');
                // $kategori_barang_validation->setError('Value is not in the list.');
                // $kategori_barang_validation->setPromptTitle('Pick from the list');
                // $kategori_barang_validation->setPrompt('Please pick a value from the drop-down list.');
                $kategori_barang_validation->setFormula1(sprintf('"%s"', implode(',', $kategori_barang_options)));

                // clone validation to remaining rows for "Kategori Barang"
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("{$kategori_barang_drop_column}{$i}")->setDataValidation(clone $kategori_barang_validation);
                }

                // set dropdown column for "Status Barang"
                $status_barang_drop_column = 'H'; // 'F' is the column index for the "Status Barang" column
    
                // set dropdown options for "Status Barang"
                $status_barang_options = ['tersedia', 'tidak'];

                // set dropdown list for first data row for "Status Barang"
                $status_barang_validation = $event->sheet->getCell("{$status_barang_drop_column}2")->getDataValidation();
                $status_barang_validation->setType(DataValidation::TYPE_LIST);
                // $status_barang_validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $status_barang_validation->setAllowBlank(true);
                // $status_barang_validation->setShowInputMessage(true);
                // $status_barang_validation->setShowErrorMessage(true);
                $status_barang_validation->setShowDropDown(true);
                // $status_barang_validation->setErrorTitle('Input error');
                // $status_barang_validation->setError('Value is not in the list.');
                // $status_barang_validation->setPromptTitle('Pick from the list');
                // $status_barang_validation->setPrompt('Please pick a value from the drop-down list.');
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

