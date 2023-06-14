<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AssetCategoryExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        // First Sheet
        $sheets[] = new ListBarangSheet();

        // Second Sheet
        $sheets[] = new ListKategoriBarangSheet();

        return $sheets;
    }

}
