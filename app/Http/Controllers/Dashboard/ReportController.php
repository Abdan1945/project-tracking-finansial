<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function exportTransaksi()
    {
        return Excel::download(new TransaksiExport, 'laporan_transaksi.xlsx');
    }
}