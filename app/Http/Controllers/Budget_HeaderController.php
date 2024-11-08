<?php

namespace App\Http\Controllers;

use App\Models\Budget_Header;
use Illuminate\Http\Request;
use App\Models\CXC;
class Budget_HeaderController extends Controller
{
    public function store(Request $request)
    {
        try {
            $patientId = $request->input('patient_id');
            $typeofpay = $request->input('type');
            $Total = $request->input('total');
            $initial =$request->input('initial_payment');
            if ($typeofpay == "Credito") {
                $cxc = CXC::where('patient_id', $patientId)->first();
        
                if (!$cxc) {
                    return response()->json(['error' => 'No se encontró una cuenta para este paciente.'], 400);
                }
                $cxcId = $cxc->id;
            } else {
                $cxcId = null;
            }
    
            $budgetHeader = new Budget_Header();
            $budgetHeader->patient_id = $patientId;
            $budgetHeader->c_x_c_id = $cxcId;
            $budgetHeader->type = $typeofpay;
            $budgetHeader->initial_payment = $initial;
            $budgetHeader->Total = $Total;
            
            $budgetHeader->save();
    
          
            return response()->json(['message' => 'Presupuestos guardados exitosamente.', 'budget_header_id' => $budgetHeader->id], 200);
        } catch (\Exception $e) {
            \Log::error('Error al guardar el encabezado del presupuesto: ' . $e->getMessage());
            return response()->json(['error' => 'Hubo un error al guardar el presupuesto. ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id){
    try {
            $typeofpay = $request->input('type');
            $total = $request->input('total');
            $initial =$request->input('initial_payment');
            $budgetHeader = Budget_Header::findOrFail($id);
            $budgetHeader->type = $typeofpay;
            $budgetHeader->total = $total;
            $budgetHeader->initial_payment = $initial;
            $budgetHeader->save();
        
            return response()->json(['message' => 'Encabezado guardado exitosamente.', 'budget_header_id' => $budgetHeader->id], 200);
        } catch (\Exception $e) {
            \Log::error('Error al guardar el encabezado del presupuesto: ' . $e->getMessage());
            return response()->json(['error' => 'Hubo un error al guardar el presupuesto. ' . $e->getMessage()], 500);
        }
    }
    
}

