<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Log;
use App\Models\Invoice;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class SaleReportController extends Controller
{
    function SaleReportPage(){
        return Inertia::render('SaleReportPage');
    }

    function GenerateReport(Request $request){
        try{
             $startDate = Carbon::parse($request->dateRange['start']);
      $endDate = Carbon::parse($request->dateRange['end'])->endOfDay();
      $invoices = Invoice::whereBetween('created_at',[$startDate,$endDate])->with(['customer:id,name,mobile'])->get();

        $data = [
            'invoices'=>$invoices,
            'start'=>$startDate->format('Y-m-d'),
            'end'=>$startDate->format('Y-m-d'),
        ];


    $pdf = Pdf::loadView('SaleReport', $data);
    return $pdf->download('report.pdf');
        }catch(Exception $e){
          $e->getMessage().$e->getLine();
        }


    }
}
