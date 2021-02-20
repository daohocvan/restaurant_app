<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sale;
use App\Exports\SaleReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(){
        return view('report.index');
    }

    public function show(Request $request){
        $request->validate([
            'dateStart' => 'required',
            'dateEnd' => 'required'
        ]);
        $dateStart = date('Y-m-d H:i:s', strtotime($request->dateStart.' 00:00:00'));
        $dateEnd = date('Y-m-d H:i:s', strtotime($request->dateEnd.' 23:59:59'));
        $sales = Sale::whereBetween('updated_at', [$dateStart, $dateEnd])->where('sale_status', 'paid');
        return view('report.showReport')->with('dateStart', date('m/d/Y H:i:s', strtotime($request->dateStart.' 00:00:00')))->with('dateEnd', date('m/d/Y H:i:s', strtotime($request->dateEnd.' 23:59:59')))->with('totalSale', $sales->sum('total_price'))->with('sales', $sales->paginate(2));
    }

    public function export(Request $request){
        $dateStart = date('m-d-Y', strtotime($request->dateStart));
        $dateEnd = date('m-d-Y', strtotime($request->dateEnd));
        if($dateStart == $dateEnd){
            return Excel::download(new SaleReportExport($request->dateStart, $request->dateEnd), 'saleReport_' .$dateStart . '.xlsx');
        }
        else{
            return Excel::download(new SaleReportExport($request->dateStart, $request->dateEnd), $dateStart. '_saleReport_' .$dateEnd . '.xlsx');
        }

    }
}
