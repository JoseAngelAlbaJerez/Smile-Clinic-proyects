<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\RX;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pacient;
class RXController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meds = RX::all();
        $patients = Pacient::all();
        return view('RX.index',compact('meds','patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $latestMed = RX::latest()->first();
        $nextMedId = $latestMed ? $latestMed->id : 1;
    
        return view('RX.create', ['nextMedId' => $nextMedId]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'dosis' => 'required|string',
                'quantity' => 'required|numeric',
            ]);
    
            $latestMed = RX::latest()->first();
    $nextMedId = $latestMed ? $latestMed->id + 1 : 1;

    \Log::info($request->all());

            $RX = new RX();   
            $RX->id = $nextMedId; 
            $RX->quantity = $validatedData['quantity'];
            $RX->name = $validatedData['name'];
            $RX->dosis = $validatedData['dosis'];
            $RX->save();
    
            \Log::info('Patient saved successfully');
    
            return redirect()->route('RX.index')
            ->with('success', 'Medicamento Registrado Correctamente!');
         } catch (\Exception $e) {
            \Log::error('Error Registrando el Medicamento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al Registrar al Medicamento. Intente de Nuevo.');
        }
      

    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $RX = RX::where('id', $id)->firstOrFail();
            return view('RX.edit', ['RX' => $RX]);
        } catch (\Exception $e) {
            \Log::error('Error encontrando Medicina para editar: ' . $e->getMessage());
            return redirect()->back()->with('error'. $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try { 
         
            $RX = RX::findOrFail($id);
            
           
            $validatedData = $request->validate([
                'name' => 'required|string',
                'dosis' => 'required|string',
                'quantity' => 'required|numeric',
            ]);
    
            \Log::info($request->all());
    
           
            $RX->quantity = $validatedData['quantity'];
            $RX->name = $validatedData['name'];
            $RX->dosis = $validatedData['dosis'];
            $RX->save(); 
    
            return redirect()->route('RX.index')
                ->with('success', 'Medicamento Actualizado Correctamente!');
        } catch (\Exception $e) {
            \Log::error('Error Actualizando el Medicamento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al Actualizar el Medicamento. Intente de Nuevo.');
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $RX = RX::findOrFail($id);
            $RX->delete();
            return redirect()->route('RX.index')->with('success', 'Medicamento Eliminado Correctamente!');
        } catch (\Exception $e) {
            \Log::error('Error deleting RX: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al Eliminar al Medicamento. Intente de Nuevo.');
        }
    }
 
    public function getSelectedMeds(Request $request)
    {
        
        $this->validate($request, [
            'meds' => 'required|array',
            'horas' => 'required|string', 
            'dias' => 'required|string'  
        ]);
    
     
        $meds = RX::whereIn('id', $request->meds)->get();
        $hours = $request->horas; 
        $days = $request->dias;   
    
        try {
            // Cargar la vista para el PDF
            $pdf = PDF::loadView('pdf.meds_report', ['meds' => $meds ,'hours' => $hours,
            'days' => $days]);
            
            // Devolver el PDF como un flujo
            return $pdf->stream('reporte_medicamentos.pdf');
        } catch (\Exception $e) {
            \Log::error('Error al generar el PDF: ' . $e->getMessage());
            return response()->json(['error' => 'Error al generar el PDF'], 500);
        }
    }
    public function getSelectedMedswithPatients(Request $request)
    {
      
    $this->validate($request, [
        'meds' => 'required|array',
        'patient_id' => 'required|integer',
        'meds.*.id' => 'required|integer', 
        'meds.*.hour' => 'required|numeric', 
        'meds.*.day' => 'required|numeric'  
    ]);

    $medsData = collect($request->meds)->map(function ($med) {
        $medication = RX::find($med['id']);
        return [
            'medication' => $medication,
            'hour' => $med['hour'],
            'day' => $med['day'],
            'dose' => $medication->dose
        ];
    });
    
    $patient = Pacient::where('pacient_id', $request->patient_id)->first();

    try {
        $pdf = PDF::loadView('pdf.meds_report_with_patients', [
            'medsData' => $medsData,
            'patient' => $patient
        ]);

        return $pdf->stream('reporte_medicamentos.pdf');
    } catch (\Exception $e) {
        \Log::error('Error al generar el PDF: ' . $e->getMessage());
        return response()->json(['error' => 'Error al generar el PDF'], 500);
    }
}
    
    
    
    
    

}
