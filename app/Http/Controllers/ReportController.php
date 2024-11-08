<?php

namespace App\Http\Controllers;

use App\Models\Abono;
use App\Models\Budget;
use App\Models\Budget_Header;
use App\Models\CXC;
use App\Models\Odontodiagrama;
use App\Models\Pacient;
use App\Models\Pettycash;
use App\Models\Event;
use App\Models\RX;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class ReportController extends Controller
{
    //

    public function index(){

        $patient = Pacient::all();
        $odontograph = Odontodiagrama::all();
        $budgets = Budget_Header::all();
        $cxc = CXC::all();
        $abonos = Abono::all();
        $expenses = Pettycash::all();
        $events = Event::all();
        $RX = RX::all();

        return view('report.index', compact('patient','odontograph','budgets','cxc','abonos','expenses','events','RX'));
    }
    public function generate(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $table1 = $request->input('select-1');
        $table2 = $request->input('select-2');
        $reportData = null;
    
        switch ("$table1-$table2") {
    
            // Paciente por Odontograma
            case 'patient-odontograph':
                $reportData = Pacient::with(['odontographs' => function($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }])->get();
                $pdf = PDF::loadView('pdf.patient_odontograph_report', compact('reportData'));
                $pdf->stream();
                return view('report', compact('reportData'));
    
            // Paciente por Presupuestos
            case 'patient-budgets':
                $reportData = Pacient::with(['budgets' => function($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }])->get();
                $pdf = PDF::loadView('pdf.patient_budget_report', compact('reportData'));
                $pdf->stream();
                return view('report', compact('reportData'));
    
            // Paciente por Cuentas por Cobrar
            case 'patient-cxc':
                $reportData = Pacient::with(['cxc' => function($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }])->get();
                $pdf = PDF::loadView('pdf.patient_cxc_report', compact('reportData'));
                $pdf->stream();
                return view('report', compact('reportData'));
    
            // Paciente por Abonos
            case 'patient-abonos':
                $reportData = Pacient::with(['cxc.abonos' => function($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }])->get();
                $pdf = PDF::loadView('pdf.patient_abonos_report', compact('reportData'));
                $pdf->stream();
                return view('report', compact('reportData'));
    
            // Presupuestos por Abonos
            case 'budgets-abonos':
                $reportData = Budget::with(['abonos' => function($query) use ($startDate, $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }])->get();
                $pdf = PDF::loadView('pdf.budget_abonos_report', compact('reportData'));
                $pdf->stream();
                return view('report', compact('reportData'));
            default:
                return back()->withErrors(['message' => 'Combinación de tablas no válida.', 505]);
        }
    
        return view('report', compact('reportData'));
    }
    
    
}
