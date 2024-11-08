<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Budget;
use Illuminate\Http\Request;
use App\Models\Abono;
use App\Models\Pacient;
use App\Models\CXC;
class AbonoController extends Controller
{
    public function deleteBudget($patientId)
    {
     
        $budget = Budget::where('patient_id', $patientId)->first();
        
        if ($budget) {
            $budget->delete(); 
        }
    }
    public function destroy($id){
        try{
            $abono = Abono::find($id);

            $abono->delete();
            return response()->json(['mensaje' => 'Abono eliminado correctamente.'], 200);
        }catch(\Exception $e){
            \Log::error('Error deleting abono : ' . $e->getMessage());
            return response()->json(['error' => 'Error al eliminar el Abono. Intente de nuevo.'], 500);
        }
    }
  
    public function print($id)
    {
    
        try{
        $abono = Abono::with(['patient','CXC'])->find($id); 
    
        // Generate PDF
        $pdf = Pdf::loadView('abono.print', compact('abono'));
      
    
        return $pdf->stream('abono_' . $abono->id . '.pdf'); 
    }catch (\Exception $e) {
        \Log::error('Error printing abono : ' . $e->getMessage());
        return response()->json(['error' => 'Error al Imprimir el Abono. Intente de nuevo.'], 500);
    }
    }
    public function store(Request $request){
        $datos = $request->input('abonos');
        $patientId = $request->input('patient_id');
        $abonoscxc = $request->input('abonoscxc');
    
      
    
        if (empty($datos)) {
            return response()->json(['error' => 'Datos de abonos no proporcionados.'], 400);
        }
    
        if (!is_array($abonoscxc) || empty($abonoscxc)) {
            return response()->json(['error' => 'No se encontraron datos de CXC.'], 400);
        }
    
        $cxcData = $abonoscxc[0];
        $cxcId = $cxcData['cxc_id'] ?? null;
        $abonar = $cxcData['abonar'] ?? null;
    
        if ($cxcId === null || $abonar === null) {
            return response()->json(['error' => 'Los datos de CXC son incompletos.'], 400);
        }
    
        foreach ($datos as $dato) {
            if (empty($dato['procedure'])) {
                return response()->json(['error' => 'El Abono no puede estar vacío.'], 400);
            }
    
            $Abono = new Abono();
            $Abono->procedure = $dato['procedure'];
            $Abono->treatment = $dato['treatment'];
            $Abono->quantity = $dato['quantity'];
            $Abono->amount = $dato['amount'];
            $Abono->coberture = $dato['coberture'];
            $Abono->discount = $dato['discount'];
            $Abono->total = $dato['total'];
            $Abono->c_x_c_id = $cxcId; 
            $Abono->abonar = $abonar;
            $Abono->patient_id = $patientId;
            $Abono->save();
            $abonos = [$Abono];
        }
    
        return response()->json(['mensaje' => 'Abono registrado correctamente.','abonos'=>$abonos], 200);
    }
    public function report($patientId)
    {
       
        $abonos = Abono::where('patient_id', $patientId)->get();
        $patient = Pacient::find($patientId);
        
        if (!$patient) {
            return response()->json(['error' => 'No se encontró el paciente.'], 404);
        }
    
        $CXC = CXC::where('patient_id', $patientId)->latest()->first(); 
    
        if (!$CXC) {
            return response()->json(['error' => 'No se encontró la cuenta por cobrar para el paciente.'], 404);
        }
    
        $Abonoheader = Abono::where('c_x_c_id', $CXC->id)->latest()->first();
    
        try {
            // Generate the PDF using the view
            $pdf = PDF::loadView('pdf.abono_report', [
                'Abonos' => $abonos,
                'patient' => $patient,
                'CXC' => $CXC,
                'Abonoheader' => $Abonoheader,
            ]);
    
            // Stream the PDF in the browser
            return $pdf->stream('reporte_abonos.pdf');
        } catch (\Exception $e) {
            \Log::error('Error al generar el PDF: ' . $e->getMessage());
            return response()->json(['error' => 'Error al generar el PDF'], 500);
        }
    }
    
   
   
}