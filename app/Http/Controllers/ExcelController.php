<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\AssetJenisExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function index(){
        return Excel::download(new AssetJenisExport, 'templateInputBarang.xlsx');
    }
}

