<?php

namespace App\Exports;

use App\Sale;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SaleReportExport implements FromView
{
    private $date_start;
    private $date_end;
    private $sales;
    private $totalSale;

    public function __construct($dateStart, $dateEnd){
        $date_start = date('Y-m-d H:i:s', strtotime($dateStart .' 00:00:00'));
        $date_end = date('Y-m-d H:i:s', strtotime($dateEnd .' 23:59:59'));
        $sales = Sale::whereBetween('updated_at', [$date_start, $date_end])->where('sale_status', 'paid')->get();
        $totalSale = $sales->sum('total_price');
        $this->date_start = $date_start;
        $this->date_end = $date_end;
        $this->sales = $sales;
        $this->totalSale = $totalSale;
    }

    public function view(): View
    {
        return view('exports.salereport', [
            'sales' => $this->sales,
            'totalSale' => $this->totalSale,
            'dateStart' => $this->date_start,
            'dateEnd' => $this->date_end
        ]);
    }
}
