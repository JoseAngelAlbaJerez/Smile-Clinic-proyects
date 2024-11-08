<?php

namespace App\Http\Controllers;


use App\Models\Pettycash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $expenses = Pettycash::all();
  return view('expenses.index',compact('expenses'));
}

public function report(Request $request){
    $startDate = $request->input('startDate'); 
    $endDate = $request->input('endDate'); 
    
    $short_startDate =$request->input('startDate');
    $short_endDate =$request->input('endDate');

    $Pettycash = Pettycash::whereBetween('date', [$startDate, $endDate])->get();
    
   
  

    try {
        $pdf = PDF::loadView('pdf.expenses_report', ['Pettycash' => $Pettycash,'startDate' => $short_startDate,'endDate' =>$short_endDate ]);
        return $pdf->stream('reporte_ingresos.pdf'); 
    } catch (\Exception $e) {
        \Log::error('Error al generar el PDF: ' . $e->getMessage());
        return response()->json(['error' => 'Error al generar el PDF'], 500);
    }
}

public function generateDailyReport()
{
    $today = Carbon::today();
    $expenses = Pettycash::whereDate('date', $today)->get();
    
    // Lógica para generar PDF con $expenses
    return $this->generatePdf($expenses);
}

public function generateWeeklyReport()
{
    $startOfWeek = Carbon::now()->startOfWeek();
    $endOfWeek = Carbon::now()->endOfWeek();
    $expenses = Pettycash::whereBetween('date', [$startOfWeek, $endOfWeek])->get();
    
    return $this->generatePdf($expenses);
}

public function generateBiweeklyReport()
{
    $startOfBiweek = Carbon::now()->subWeeks(2);
    $expenses = Pettycash::where('date', '>=', $startOfBiweek)->get();
    
    return $this->generatePdf($expenses);
}

public function generateMonthlyReport()
{
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();
    $expenses = Pettycash::whereBetween('date', [$startOfMonth, $endOfMonth])->get();
    
    return $this->generatePdf($expenses);
}

private function generatePdf($expenses)
{
    $pdf = PDF::loadView('pdf.expenses', compact('expenses'));
    return $pdf->download('reporte.pdf');
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'amount' => 'required|numeric',
                'date' => 'required|date',
            ]);
    
     

   

            $expenses = new Pettycash();   
          
            $expenses->name = $validatedData['name'];
            $expenses->amount = $validatedData['amount'];
            $expenses->date = $validatedData['date'];
            $expenses->save();
    
            
    
            return redirect()->route('expenses.index')
            ->with('success', 'Egreso Registrado Correctamente!');
         } catch (\Exception $e) {
            \Log::error('Error Registrando el Egreso: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al Registrar al Egreso. Intente de Nuevo.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expense = Pettycash::findOrFail($id);

        return view('expenses.edit', ['expense' => $expense]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try { 
       
              $expense = Pettycash::findOrFail($id);
            
        
              $validatedData = $request->validate([
                  'amount' => 'required|numeric',
                  'name' => 'required|string',
                  'date' => 'required|date',
                  
              ]);
             
            $expense->name = $validatedData['name'];
            $expense->amount = $validatedData['amount']; 
            $expense->date = $validatedData['date'];  
            
       
            $expense->save();
            return redirect()->route('expenses.index')->with('success', 'Egreso Actualizado Correctamente!');
        } catch (\Exception $e) {
            \Log::error('Error updating expense: ' . $e->getMessage());
           
             return redirect()->route('expenses.edit', ['id' => $expense])
             ->with('error', 'Error al Registrar al Egreso. Intente de Nuevo!: ' . $e->getMessage());
    
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $expense = Pettycash::findOrFail($id);
            $expense->delete();
            return redirect()->route('expenses.index')->with('success', 'Egreso Eliminado Correctamente!');
        } catch (\Exception $e) {
            \Log::error('Error deleting expense: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al Eliminar al Egreso. Intente de Nuevo.');
        }
    }
}
