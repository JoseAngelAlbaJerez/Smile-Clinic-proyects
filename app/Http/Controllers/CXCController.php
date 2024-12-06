<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use App\Models\Pacient;
use App\Models\Abono;
use App\Models\CXC;
use Barryvdh\DomPDF\Facade\Pdf; 
class CXCController extends Controller
{
    public function index()
{

    $CXCS = CXC::with('patient', 'abonos', 'budgets')->get();
    
 
    foreach ($CXCS as $CXC) {
        $CXC->abonos_count = Abono::where('c_x_c_id', $CXC->id)->count();
    }
    
    return view('CXC.index', compact('CXCS'));
}

   public function create()
{
    $patients = Pacient::all();
    $CXCS = CXC::all()->keyBy('patient_id'); 

    \Log::info('Total patients:', ['count' => $patients->count()]);

    $patientsWithBalance = $patients->filter(function ($patient) use ($CXCS) {
        $hasBalance = isset($CXCS[$patient->pacient_id]) && $CXCS[$patient->pacient_id]->balance > 0;
    
        \Log::info('Patient:', [
            'id' => $patient->pacient_id,
            'has_balance' => $hasBalance,
            'balance' => $hasBalance ? $CXCS[$patient->pacient_id]->balance : 'N/A'
        ]);
        return $hasBalance;
    });
    \Log::info('Patients with balance:', ['count' => $patientsWithBalance->count()]);

    $budgets = Budget::whereIn('patient_id', $patientsWithBalance->pluck('patient_id'))->get();
    $abonos = Abono::whereIn('patient_id', $patientsWithBalance->pluck('patient_id'))->get();

    return view('CXC.create', compact('patientsWithBalance', 'budgets', 'abonos', 'CXCS'));
}
public function generateReceiptPDF($patient_id, $abonosEncoded)
{
    // Decodifica los abonos si se proporcionan
    if ($abonosEncoded) {
        $abonosIds = json_decode(urldecode($abonosEncoded), true); // Decodifica como un array
        // Obtiene los abonos basados en los IDs decodificados
        $abonos = Abono::whereIn('id', $abonosIds)->get(); // Asegúrate de que esto devuelve objetos Abono
    } else {
        // Si no se proporcionan abonos, obtiene todos los abonos del paciente
        $abonos = Abono::where('patient_id', $patient_id)->get();
    }
  
    $patient = Pacient::find($patient_id);
    $CXC = CXC::where('patient_id', $patient_id)->latest()->first(); 

    if (!$CXC) {
        return response()->json(['error' => 'No se encontró la cuenta por cobrar para el paciente.'], 404);
    }

    $Abonoheader = Abono::where('c_x_c_id', $CXC->id)->latest()->first();

    $pdf = PDF::loadView('pdf.CXC_receipt_report', [
        'Abonos' => $abonos,
        'patient' => $patient,
        'CXC' => $CXC,
        'Abonoheader' => $Abonoheader,
    ]);

    return $pdf->stream('CXC_receipt_report.pdf');
}




public function show($id)
{
    $Abonos = Abono::where('patient_id', $id)->get();
    $patient = Pacient::where('pacient_id', $id)->first();
    $total_abonos = $Abonos->sum('abonar');
    return view('Abono.show', compact('Abonos','patient','total_abonos'));
}

    
public function store(Request $request)
{
    $validatedData = $request->validate([
        'patient_id' => 'required|exists:pacient,pacient_id',
        'balance' => 'required|numeric',
        'status' => 'required|string',
       
    
        'total' => 'required|numeric',
    ]);

    try {
        $cxc = CXC::where('patient_id', $request->patient_id)->first();

        if ($cxc) {
            $cxc->balance += $request->balance;  
            $cxc->status = $request->status;
            
          
            $cxc->total += $request->total;  
            $cxc->save();
        } else {
            $cxc = CXC::create($validatedData);
        }

        return response()->json(['message' => 'CXC guardada correctamente', 'patient_id' => $cxc->patient_id]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al guardar CXC: ' . $e->getMessage()], 500);
    }
}


    public function storeAbono(Request $request)
{
    $patientId = $request->input('patient_id');
    $abonos = $request->input('abonos'); 


    foreach ($abonos as $abono) {
        $budget = Budget::find($abono['budget_id']);
        
        if ($budget) {
            $budget->balance -= $abono['amount']; 
            if ($budget->balance <= 0) {
                $budget->balance = 0; 
            }
            $budget->save();
        }
    }

    $this->actualizarCxc($patientId);

    return response()->json(['message' => 'Abono registrado con éxito']);
}

public function actualizarCxc($patientId)
{
    $cxc = Cxc::where('patient_id', $patientId)->first();
    if ($cxc) {
        $budgets = Budget::where('patient_id', $patientId)->where('balance', '>', 0)->get();
        $cxc->balance = $budgets->sum('balance');
        $cxc->status = $cxc->balance > 0 ? 'pendiente' : 'pagado';
        $cxc->save();
    }
}

    public function filtrarBudgets($id)
    {
       
        $credito = 'credito';
      
        
            $abonos = Abono::where('patient_id', $id)->get();
            
        
        $budgets = Budget::where('patient_id', $id)
                         ->where('type', $credito)
                         ->get();
    
     
                         return response()->json([
                            'budgets' => $budgets,
                            'abonos' => $abonos
                        ]);
                    }
    

    public function update(Request $request, $id){
        $Account = CXC::findOrFail($id);
        try {
            $request->validate([
                
                'balance' => 'required',
                'status' => 'required',
                'total' => 'nullable|numeric',
               
            ]);
          
          
            $Account->status = $request->status;
            $Account->balance = $request->balance;
            
             
            $Account->save();
    
            return response()->json(['mensaje' => 'Cuenta registrada correctamente.'], 200);

         } catch (\Exception $e) {
            \Log::error('Error Registrando la Cuenta: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al Registrar la Cuenta. Intente de Nuevo.');

        }
    }
 public function destroy($id)
{
 
    $cxc = CXC::find($id);
    $budgets = Budget::where('c_x_c_id', $id);
    $abonos = Abono::where('c_x_c_id', $id);
  
    if (!$cxc) {
        return redirect()->back()->with('error', 'La cuenta no existe.');
    }
    $abonos->delete();
    $budgets->delete();
    $cxc->delete();

  
    return redirect()->route('CXC.index')->with('success', 'La cuenta ha sido eliminada correctamente.');
}

    
            

        
    }