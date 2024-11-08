<?php

namespace App\Http\Controllers;

use App\Models\Budget_Header;
use Illuminate\Http\Request;
use App\Models\Budget; 
use App\Models\CXC;
use App\Models\Pacient;

use Barryvdh\DomPDF\Facade\Pdf; 
class BudgetController extends Controller
{
    public function store(Request $request)
{
    $datos = $request->input('datos');
    $patientId = $request->input('patient_id');
    $typeofpay = $request->input('type');
    $budgetHeaderId = $request->input('budget_header_id'); 
    $budgets = []; 
    
    if ($typeofpay == "Credito") {
        $cxc = CXC::where('patient_id', $patientId)->first();

        if (!$cxc) {
            return response()->json(['error' => 'No se encontró una cuenta para este paciente.'], 400);
        }
        $cxcId = $cxc->id;
    } else {
        $cxcId = null;
    }
    foreach ($datos as $dato) {
        if (empty($dato['procedure']) || empty($typeofpay)) {
            return response()->json(['error' => 'El presupuesto no puede estar vacío.'], 400);
        }

        $budget = new Budget();
        $budget->procedure = $dato['procedure'];
        $budget->treatment = $dato['treatment'];
        $budget->quantity = $dato['quantity'];
        $budget->amount = $dato['amount'];
        $budget->coberture = $dato['coberture'];
        $budget->discount = $dato['discount'];
        $budget->total = $dato['total'];
        $budget->patient_id = $patientId;
        $budget->type = $typeofpay;
        $budget->c_x_c_id = $cxcId;
        $budget->budget_header_id = $budgetHeaderId;
        $budget->save();
        $budgets[] = $budget; // Almacena el presupuesto en el array
    }

    return response()->json(['message' => 'Presupuestos guardados exitosamente.', 'budgets' => $budgets, 'patient_id' => $patientId]);
}
public function updateBudgets(Request $request)
{
    $budgetsToUpdate = $request->input('budgets');

    // Verificar los datos recibidos
    \Log::info('Budgets to update:', $budgetsToUpdate);

    try {
        // Validar que sea un arreglo
        if (!is_array($budgetsToUpdate)) {
            return response()->json([
                'success' => false,
                'error' => 'Los datos de los presupuestos no son válidos.',
            ], 400);
        }

        // Procesar los presupuestos
        foreach ($budgetsToUpdate as $budgetData) {
            if (is_array($budgetData) && isset($budgetData['budget_id'], $budgetData['remaining_amount'])) {
                $budget = Budget::find($budgetData['budget_id']);
                
                if ($budget) {
                    $budget->total = $budgetData['remaining_amount'];
                    $budget->save();
                } else {
                    return response()->json([
                        'success' => false,
                        'error' => 'Presupuesto no encontrado con ID: ' . $budgetData['budget_id'],
                    ], 404);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Datos de presupuesto inválidos.',
                ], 400);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Presupuestos actualizados con éxito.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Hubo un error al actualizar los presupuestos: ' . $e->getMessage(),
        ], 500);
    }
}


public function index(){
    $budgets = Budget_Header::with('patient')->get();
    $patients = Pacient::all(); 
    
    return view('budget.index', compact('budgets', 'patients'));
}
public function print($id)
{

    try{
    $budget = Budget_Header::with(['patient', 'budgetDetails','cxc'])->findOrFail($id); // Assuming 'header' is the relationship for budget header

    // Generate PDF
    $pdf = Pdf::loadView('budget.print', compact('budget'));

    return $pdf->stream('budget_' . $budget->id . '.pdf'); 
}catch (\Exception $e) {
    \Log::error('Error printing budget and header: ' . $e->getMessage());
    return response()->json(['error' => 'Error al Imprimir el presupuesto. Intente de nuevo.'], 500);
}
}


public function generatePDF($patient_id, $budgetsEncoded = null)
{
    $patient = Pacient::find($patient_id);
    if (!$patient) {
        return response()->json(['error' => 'Paciente no encontrado.'], 404);
    }

    if ($budgetsEncoded) {
        $budgets = json_decode(urldecode($budgetsEncoded), true);
        if (!$budgets) {
            return response()->json(['error' => 'No se pudo decodificar los presupuestos.'], 400);
        }
    } else {
        $budgets = Budget::where('patient_id', $patient_id)->get();
    }

  
    $pdf = PDF::loadView('pdf.budget_report', [
        'budgets' => $budgets, 
        'patient' => $patient,
      
    ]);

    return $pdf->stream('reporte_budgets.pdf');
}

public function generatePDFCXC($patient_id, $budgetIds)
{
    $budgetIdsArray = json_decode(urldecode($budgetIds), true);
    $budgets = Budget::whereIn('id', $budgetIdsArray)->get();
    $patient = Pacient::find($patient_id);
    $total = Budget_Header::where('patient_id', $patient_id)
    ->where('type', 'Credito')
    ->sum('Total');


    if (!$patient) {
        return response()->json(['error' => 'Paciente no encontrado.'], 404);
    }
    $CXC = CXC::where('patient_id', $patient_id)->latest()->first();

    if (!$CXC) {
        return response()->json(['error' => 'CXC no encontrado.'], 404);
    }
 
    $pdf = PDF::loadView('pdf.budget_report_CXC', compact('budgets', 'patient','CXC','total'));

    return $pdf->stream();
}

public function delete($id){

    try {
        // Obtiene el Budget_Header correspondiente al ID
        $budgetHeader = Budget_Header::find($id);

        if (!$budgetHeader) {
            return response()->json(['error' => 'Presupuesto no encontrado.'], 404);
        }

        // Si el presupuesto es de tipo crédito, ajusta el balance en CXC
        if ($budgetHeader->type === "Credito") {
            $cxcId = $budgetHeader->c_x_c_id;
            
            if ($cxcId) {
                $CXCS = CXC::find($cxcId);

                if ($CXCS) {
                    $CXCS->balance = ($CXCS->balance + $budgetHeader->initial_payment) - $budgetHeader->Total;
                    $CXCS->total -= $budgetHeader->Total;
                    $CXCS->save();
                } else {
                    \Log::error("Cuenta CXC no encontrada para el presupuesto ID {$budgetHeader->id}");
                }
            }
        }

        // Eliminar los presupuestos individuales asociados al `Budget_Header`
        Budget::where('budget_header_id', $budgetHeader->id)->delete();

        // Finalmente, eliminar el registro de Budget_Header
        $budgetHeader->delete();

        return response()->json(['mensaje' => 'Presupuesto y encabezado eliminados correctamente.'], 200);

    } catch (\Exception $e) {
        \Log::error('Error deleting budget and header: ' . $e->getMessage());
        return response()->json(['error' => 'Error al eliminar el presupuesto. Intente de nuevo.'], 500);
    }
}


    public function destroy(Request $request) {
       
        $this->validate($request, [
            'ids' => 'required|array',
            'ids.*' => 'exists:budgets,id', 
        ]);
    
        try {
            Budget::destroy($request->ids);
            return response()->json(['mensaje' => 'Presupuestos eliminados correctamente.'], 200);
        } catch (\Exception $e) {
            \Log::error('Error deleting budgets: ' . $e->getMessage());
            return response()->json(['error' => 'Error al eliminar los presupuestos. Intente de nuevo.'], 500);
        }
    }
    public function edit($id, $pacientid)
    {
        $budget = Budget_Header::find($id);
        $budget_id = Budget::latest('id')->value('id');
        $budget_detalle = Budget::where('budget_header_id', $budget->id)->get();
        $paciente = Pacient::find($pacientid);
        $cxc = CXC::where('');
        
    return view('budget.edit', compact('budget', 'budget_detalle', 'paciente','budget_id'));
    }
    
    public function update(Request $request)
    {
        $datos = $request->input('datos');
        $patientId = $request->input('patient_id');
        $typeofpay = $request->input('type');
        $budgetHeaderId = $request->input('budget_header_id');
        $budgets = [];
    
        if ($typeofpay === "Credito") {
            $cxc = CXC::where('patient_id', $patientId)->first();
            if (!$cxc) {
                return response()->json(['error' => 'No se encontró una cuenta para este paciente.'], 400);
            }
            $cxcId = $cxc->id;
        } else {
            $cxcId = null;
        }
    
        foreach ($datos as $dato) {
            if (empty($dato['procedure'])) {
                return response()->json(['error' => 'El presupuesto no puede estar vacío.'], 400);
            }
    
            $budget = Budget::find($dato['id']); // Asegurarse de encontrar el presupuesto por ID
            if (!$budget) {
                continue; // Salta si no se encuentra el presupuesto
            }
    
            $budget->procedure = $dato['procedure'];
            $budget->treatment = $dato['treatment'];
            $budget->quantity = $dato['quantity'];
            $budget->amount = $dato['amount'];
            $budget->coberture = $dato['coberture'];
            $budget->discount = $dato['discount'];
            $budget->total = $dato['total'];
            $budget->patient_id = $patientId;
            $budget->type = $typeofpay;
            $budget->c_x_c_id = $cxcId;
            $budget->budget_header_id = $budgetHeaderId;
            $budget->save();
    
            $budgets[] = $budget;
        }
    
        return response()->json(['message' => 'Presupuestos guardados exitosamente.', 'budgets' => $budgets, 'patient_id' => $patientId]);
    }
    
    
 

    
}