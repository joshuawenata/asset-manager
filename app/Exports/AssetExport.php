<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data){
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'id',
            'nomor seri',
            'status',
            'spesifikasi',
            'lokasi saat ini',
            'divisi',
            'jenis aset'
        ];
    }
}
