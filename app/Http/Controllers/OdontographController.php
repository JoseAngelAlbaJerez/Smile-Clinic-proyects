<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Odontodiagrama;
use Alert;
use Illuminate\Support\Facades\Storage;
use App\Models\Pacient;
use Carbon\Carbon;
class OdontographController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveData(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'patient_id' => 'required',
            'caries' => 'required',
            'restauraciones' => 'required',
            'extracciones' => 'required',
            'ausencias' => 'required',
            'puentes' => 'required',
            'endodoncias' => 'required',
            'implantes' => 'required',
            'image' => 'required',
        ]);
    
      
        $odontodiagrama = Odontodiagrama::create([
            'patient_id' => $request->input('patient_id'),
            'caries' => $request->input('caries'),
            'restauraciones' => $request->input('restauraciones'),
            'extracciones' => $request->input('extracciones'),
            'ausencias' => $request->input('ausencias'),
            'puentes' => $request->input('puentes'),
            'endodoncias' => $request->input('endodoncias'),
            'implantes' => $request->input('implantes'),
        ]);
    
        // Procesar y guardar la imagen
        if ($request->has('image')) {
            // Obtener el dataURL y decodificarlo
            $imageData = $request->input('image');
            $imageData = explode(',', $imageData)[1]; // Extraer la parte de base64
            $imageData = base64_decode($imageData);
    
            // Generar un nombre único para la imagen
            $imageName = 'odontodiagrama_' . $odontodiagrama->id . '_' . time() . '.png';
    
            // Guardar la imagen en la carpeta storage/odontodiagrams
            $path = storage_path('app/public/odontodiagrams/' . $imageName);
            file_put_contents($path, $imageData);
    
            // Guardar la ruta de la imagen en la base de datos
            $odontodiagrama->image_path = 'storage/odontodiagrams/' . $imageName;
            $odontodiagrama->save();
        }
    
        
       
        return response()->json(['odontodiagram_id' => $odontodiagrama->id]);
}


public function createOdontodiagram(Request $request)
{
    $pacient_id = $request->input('pacient_id');
    
    // Aquí asumo que tienes un modelo Patient para obtener los datos del paciente
    $patient = Pacient::find($pacient_id);

    if ($patient) {
        // Calcular la edad del paciente
        $age = Carbon::parse($patient->date_of_birth)->age;

        if ($age > 17) {
            // Redirigir a la ruta del odontodiagrama para adultos
            return redirect()->route('odontograph', ['pacient_id' => $pacient_id])
                ->with('success', 'Paciente Registrado Correctamente!');
        } else {
            // Redirigir a la ruta del odontodiagrama para niños
            return redirect()->route('odontographchild', ['pacient_id' => $pacient_id])
                ->with('success', 'Paciente Registrado Correctamente!');
        }
    }

    // Manejo de errores si el paciente no se encuentra
    return redirect()->back()->with('error', 'Paciente no encontrado.');
}

public function index() {

    $odontos = Pacient::whereHas('odontodiagramas')->get();
    $patients = Pacient::whereDoesntHave('odontodiagramas')->get();
    return view('odontograph.index', compact('odontos','patients'));
}
public function show($id){

    $odontograph = Odontodiagrama::find($id);
    return view('odontograph.show',compact('odontograph'));
}
public function edit($id) {
    $pacient = Pacient::findOrFail($id);
    $odontodiagram = Odontodiagrama::where('patient_id', $id)->first(); 

    return view('odontograph.edit', [
        'pacient' => $pacient,
        'odontodiagram' => $odontodiagram  
    ]);
}
public function editchild($id){
    $pacient = Pacient::findOrFail($id);
    $odontodiagram = Odontodiagrama::where('patient_id', $id)->first(); 

    return view('odontograph.editchild', [
        'pacient' => $pacient,
        'odontodiagram' => $odontodiagram  
    ]);
}


public function update($id, Request $request) 
{
    $request->validate([
        'patient_id' => 'required',
        'caries' => 'required',
        'restauraciones' => 'required',
        'extracciones' => 'required',
        'ausencias' => 'required',
        'puentes' => 'required',
        'endodoncias' => 'required',
        'implantes' => 'required',
        'image' => 'required', // Asegúrate de que esto esté validado
    ]);

    $odontodiagrama = Odontodiagrama::findOrFail($id);

    $odontodiagrama->update([
        'patient_id' => $request->input('patient_id'),
        'caries' => $request->input('caries'),
        'restauraciones' => $request->input('restauraciones'),
        'extracciones' => $request->input('extracciones'),
        'ausencias' => $request->input('ausencias'),
        'puentes' => $request->input('puentes'),
        'endodoncias' => $request->input('endodoncias'),
        'implantes' => $request->input('implantes'),
    ]);

    if ($request->has('image')) {
        $imageData = $request->input('image');
        $imageData = explode(',', $imageData)[1]; // Extraer la parte de base64
        $imageData = base64_decode($imageData);

        $imageName = 'odontodiagrama_' . $odontodiagrama->id . '_' . time() . '.png';
        $path = storage_path('app/public/odontodiagrams/' . $imageName);
        file_put_contents($path, $imageData);

        $odontodiagrama->image_path = 'storage/odontodiagrams/' . $imageName;
        $odontodiagrama->save();
    }

    return response()->json(['odontodiagram_id' => $odontodiagrama->id]);
}
public function updatechild($id, Request $request) 
{
    $request->validate([
        'patient_id' => 'required',
        'caries' => 'required',
        'restauraciones' => 'required',
        'extracciones' => 'required',
        'ausencias' => 'required',
        'puentes' => 'required',
        'endodoncias' => 'required',
        'implantes' => 'required',
        'image' => 'required', // Asegúrate de que esto esté validado
    ]);

    $odontodiagrama = Odontodiagrama::findOrFail($id);

    $odontodiagrama->update([
        'patient_id' => $request->input('patient_id'),
        'caries' => $request->input('caries'),
        'restauraciones' => $request->input('restauraciones'),
        'extracciones' => $request->input('extracciones'),
        'ausencias' => $request->input('ausencias'),
        'puentes' => $request->input('puentes'),
        'endodoncias' => $request->input('endodoncias'),
        'implantes' => $request->input('implantes'),
    ]);

    if ($request->has('image')) {
        $imageData = $request->input('image');
        $imageData = explode(',', $imageData)[1]; // Extraer la parte de base64
        $imageData = base64_decode($imageData);

        $imageName = 'odontodiagrama_' . $odontodiagrama->id . '_' . time() . '.png';
        $path = storage_path('app/public/odontodiagrams/' . $imageName);
        file_put_contents($path, $imageData);

        $odontodiagrama->image_path = 'storage/odontodiagrams/' . $imageName;
        $odontodiagrama->save();
    }

    return response()->json(['odontodiagram_id' => $odontodiagrama->id]);
}
public function destroy($id){
 
    try{
        $odontograph = Odontodiagrama::where('patient_id',$id)->latest()->first();
        $odontograph->delete();
        return redirect()->route('odontograph.index')->with('success', 'Odontodiagrama Eliminado Correctamente!');
    } catch (\Exception $e) {
        \Log::error('Error deleting Odontograph: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error al Eliminar al Odontodiagrama. Intente de Nuevo.');
    }

}






public function showBudget($patient_id)
{
   
    $odontodiagrama = Odontodiagrama::where('patient_id', $patient_id)->first();

 
    $paciente = Pacient::find($patient_id);

    if (!$paciente) {
        abort(404, 'Paciente no encontrado.');
    }
    
    return view('budget', compact('odontodiagrama', 'paciente'));
}


}