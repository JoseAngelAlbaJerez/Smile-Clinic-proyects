<?php

namespace App\Http\Controllers;

use App\Models\Budget_Header;
use Illuminate\Http\Request;
use App\Models\Budget;
use App\Models\Abono;
use Carbon\Carbon;
use App\Models\Pacient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abonos = Abono::with('patient')->get(); 
    
        foreach ($abonos as $abono) {
            $abono->patient_name = DB::table('pacient')->where('pacient_id', $abono->patient_id)->value('name');
        }
    
        $budgets = Budget_Header::where('type', 'contado')
                     ->whereHas('patient')
                     ->with('patient')
                     ->get();
    
        return view('income.index', compact('budgets', 'abonos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getDailyIncome()
{
    $abonos = Abono::whereDate('created_at', Carbon::today())->get(); 
    $budgets = Budget::whereDate('created_at', Carbon::today())->get(); 

    $budgetssum = $budgets->sum('Total');
    $abonossum = $abonos->sum('abonar');
    $income = $abonossum + $budgetssum;
    
    return [
        'income' => $income,
        'budgets' => $budgets,
        'abonos' => $abonos,
    ];
}

public function getWeeklyIncome()
{
    $abonos = Abono::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
    $budgets = Budget::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

    $budgetssum = $budgets->sum('Total');
    $abonossum = $abonos->sum('abonar');
    $income = $abonossum + $budgetssum;

    return [
        'income' => $income,
        'budgets' => $budgets,
        'abonos' => $abonos,
    ];
}

public function getBiweeklyIncome()
{
    $abonos = Abono::whereBetween('created_at', [Carbon::now()->subWeek(1)->startOfWeek(), Carbon::now()->endOfWeek()])->get();
    $budgets = Budget::whereBetween('created_at', [Carbon::now()->subWeek(1)->startOfWeek(), Carbon::now()->endOfWeek()])->get();

    $budgetssum = $budgets->sum('Total');
    $abonossum = $abonos->sum('abonar');
    $income = $abonossum + $budgetssum;

    return [
        'income' => $income,
        'budgets' => $budgets,
        'abonos' => $abonos,
    ];
}

public function getMonthlyIncome()
{
    $abonos = Abono::whereMonth('created_at', Carbon::now()->month)->get();
    $budgets = Budget::whereMonth('created_at', Carbon::now()->month)->get();

    $budgetssum = $budgets->sum('Total');
    $abonossum = $abonos->sum('abonar');
    $income = $abonossum + $budgetssum;

    return [
        'income' => $income,
        'budgets' => $budgets,
        'abonos' => $abonos,
    ];
}

public function getYearlyIncome()
{
    $abonos = Abono::whereYear('created_at', Carbon::now()->year)->get();
    $budgets = Budget::whereYear('created_at', Carbon::now()->year)->get();

    $budgetssum = $budgets->sum('Total');
    $abonossum = $abonos->sum('abonar');
    $income = $abonossum + $budgetssum;

    return [
        'income' => $income,
        'budgets' => $budgets,
        'abonos' => $abonos,
    ];
}

    /**
     * Remove the specified resource from storage.
     */
    public function generateReport(Request $request)
    {
        $reportType = $request->input('report_type'); 
    
    
        $incomeData = 0;
    
     
        if (!in_array($reportType, ['daily', 'weekly', 'biweekly', 'monthly', 'yearly'])) {
            return response()->json(['error' => 'Tipo de reporte inválido'], 400);
        }
  
        switch ($reportType) {
            case 'daily':
                $incomeData = $this->getDailyIncome();
                break;
            case 'weekly':
                $incomeData = $this->getWeeklyIncome();
                break;
            case 'biweekly':
                $incomeData = $this->getBiweeklyIncome();
                break;
            case 'monthly':
                $incomeData = $this->getMonthlyIncome();
                break;
            case 'yearly':
                $incomeData = $this->getYearlyIncome();
                break;
        }
    
        try {
            $pdf = PDF::loadView('pdf.income_report_dated', [
                'income' => $incomeData['income'],
                'budgets' => $incomeData['budgets'], 
                'abonos' => $incomeData['abonos'], 
                'reportType' => $reportType 
            ]);
          
            return $pdf->stream('reporte_ingresos.pdf');
        } catch (\Exception $e) {
            \Log::error('Error al generar el PDF: ' . $e->getMessage());
            return response()->json(['error' => 'Error al generar el PDF'], 500);
        }
    }
    public function report(Request $request) {
        $startDate = $request->input('startDate') . ' 00:00:00'; 
        $endDate = $request->input('endDate') . ' 23:59:59'; 
        
        $short_startDate =$request->input('startDate');
        $short_endDate =$request->input('endDate');
        $budgets = Budget::whereBetween('updated_at', [$startDate, $endDate])->get();
        
       
        $abonos = Abono::whereBetween('updated_at', [$startDate, $endDate])->get();
    
        try {
            $pdf = PDF::loadView('pdf.income_report', ['budgets' => $budgets, 'abonos' => $abonos,'startDate' => $short_startDate,'endDate' =>$short_endDate]);
            return $pdf->stream('reporte_ingresos.pdf'); 
        } catch (\Exception $e) {
            \Log::error('Error al generar el PDF: ' . $e->getMessage());
            return response()->json(['error' => 'Error al generar el PDF'], 500);
        }
    }
    
    
}
