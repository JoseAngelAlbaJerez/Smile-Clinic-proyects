<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Budget_Header;
use Illuminate\Http\Request;
use App\Models\Pacient;
use App\Models\Odontodiagrama;
use App\Models\CXC;
use App\Models\Abono;
use Carbon\Carbon;

use DB;
class PatientController extends Controller
{
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $patients = Pacient::all();
        return view('patient.index',compact('patients'));
    }
    public function patientscalled()
    {
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        $patients = Pacient::whereDate('updated_at','<', $sixMonthsAgo);
        return view('patient.index',compact('patients'));
        
    }
 


    public function show($id)
    {
        // Obtener el paciente
        $patient = Pacient::where('pacient_id', $id)->first();
    
        // Obtener todas las cuentas por cobrar (CXC) del paciente
        $CXCS = CXC::where('patient_id', $id)->get();
    
        // Obtener el primer odontograma del paciente
        $odontographid = Odontodiagrama::where('patient_id', $id)->first();
    
        // Obtener todos los presupuestos del paciente
        $budget = Budget_Header::where('patient_id', $id)->get();
    
        // Obtener todos los abonos del paciente
        $abonos = Abono::where('patient_id', $id)->get();
    
        // Calcular el conteo de abonos para cada CXC
        foreach ($CXCS as $CXC) {
            $abonosCount = Abono::where('c_x_c_id', $CXC->id)->count();
            $CXC->abonos_count = $abonosCount > 0 ? $abonosCount : "No ha abonado";
        }
    
        // Retornar los datos a la vista
        return view('patient.show', [
            'patient' => $patient,
            'CXCS' => $CXCS,
            'odontographid' => $odontographid,
            'budget' => $budget,
            'abonos' => $abonos,
        ]);
    }
    
    public function create()
    {
        $latestPatient = Pacient::latest()->first();
        $nextClientId = $latestPatient ? $latestPatient->pacient_id : 1;
    
        return view('patient.create', ['nextClientId' => $nextClientId]);
    }
    public function edit($id){
        try {
            $patient = Pacient::where('pacient_id', $id)->firstOrFail();
            return view('patient.edit', ['patient' => $patient]);
        } catch (\Exception $e) {
            \Log::error('Error finding patient for editing: ' . $e->getMessage());
            return console.log_error('error'. $e->getMessage());
        }
    }
    public function update(Request $request, $id){
        try { 
        // Encuentra al paciente que se va a actualizar
          $patient = Pacient::findOrFail($id);
        
          // Valida los datos recibidos del formulario
          $validatedData = $request->validate([
              'ars' => 'nullable|string',
              'name' => 'required|string',
              'date_of_birth' => 'required|date',
              'complicaciones' => 'required|in:si,no',
              'complicaciones_detalle' => 'nullable|string',
              'alergias' => 'required|in:si,no',
              'alergias_detalle' => 'nullable|string',
              'medicamento' => 'required|in:si,no', 
              'medicamentos_detalle' => 'nullable|string',
              'motivo_consulta' => 'nullable|string',
              'fecha' => 'required|date',
              'phone' => 'required|string',
              'Cedula' => 'required|string|regex:/^\d{3}-\d{7}-\d{1}$/',
              'address' => 'required|string',
          ]);
           // Actualiza los atributos del paciente
        $patient->ars = $validatedData['ars'];
        $patient->name = $validatedData['name']; 
        $patient->date_of_birth = $validatedData['date_of_birth'];  
        $patient->complications = $validatedData['complicaciones'] === 'si' ? 1 : 0;
        $patient->complication_detail = $validatedData['complicaciones_detalle'] ?? null;
        $patient->alergies = $validatedData['alergias'] === 'si' ? 1 : 0;
        $patient->alergies_detail = $validatedData['alergias_detalle'] ?? null;
        $patient->drugs = $validatedData['medicamento'] === 'si' ? 1 : 0;
        $patient->drugs_detail = $validatedData['medicamentos_detalle'] ?? null;
        $patient->motive = $validatedData['motivo_consulta'];
        $patient->date = $validatedData['fecha'];
        $patient->phone = $validatedData['phone'];
        $patient->Cedula = $validatedData['Cedula'];
        $patient->address = $validatedData['address'];
        // Guarda los cambios en la base de datos
        $patient->save();
        return redirect()->route('patient.index')->with('success', 'Paciente Actualizado Correctamente!');
    } catch (\Exception $e) {
        \Log::error('Error updating patient: ' . $e->getMessage());
       
         return redirect()->route('patient.edit', ['id' => $patient])
         ->with('error', 'Error al Registrar al Paciente. Intente de Nuevo!: ' . $e->getMessage());

        
    }
    }
    public function store(Request $request)
    {
       
        try {
            
    
            $validatedData = $request->validate([
                'ars' => 'nullable|string',
                'name' => 'required|string',
                'date_of_birth' => 'required|date',
                'complicaciones' => 'required|in:si,no',
                'complicaciones_detalle' => 'nullable|string',
                'alergias' => 'required|in:si,no',
                'alergias_detail' => 'nullable|string',
                'medicamento' => 'required|in:si,no', 
                'medicamentos_detalle' => 'nullable|string',
                'motivo_consulta' => 'nullable|string',
                'fecha' => 'required|date',
                'phone' => 'required|string',
                'Cedula' => 'required|string|regex:/^\d{3}-\d{7}-\d{1}$/',
                'address' => 'required|string',
            ]);
    
            $latestPatient = Pacient::latest()->first();
    $nextClientId = $latestPatient ? $latestPatient->pacient_id + 1 : 1;

    \Log::info($request->all());
           
 
            $patient = new Pacient();
            
            $patient->pacient_id = $nextClientId; 
            
            $patient->ars = $validatedData['ars'];

            $patient->name = $validatedData['name']; 
            $patient->date_of_birth = $validatedData['date_of_birth'];  
            $patient->complications = $validatedData['complicaciones'] === 'si' ? 1 : 0;
            $patient->complication_detail = $validatedData['complicaciones_detalle'] ?? null;
            $patient->alergies = $validatedData['alergias'] === 'si' ? 1 : 0;
            $patient->alergies_detail = $validatedData['alergias_detalle'] ?? null;
            $patient->drugs = $validatedData['medicamento'] === 'si' ? 1 : 0;
            $patient->drugs_detail = $validatedData['medicamentos_detalle'] ?? null;
            $patient->motive = $validatedData['motivo_consulta'];
            $patient->fecha = $validatedData['fecha'];
            $patient->phone = $validatedData['phone'];
            $patient->Cedula = $validatedData['Cedula'];
            $patient->address = $validatedData['address'];
            // Save the patient to the database
            $patient->save();
    
         
                $age = Carbon::parse($patient->date_of_birth)->age;
            if($age > 17){
                return redirect()->route('odontograph', ['pacient_id' => $nextClientId])
                ->with('success', 'Paciente Registrado Correctamente!');
            }else {
                return redirect()->route('odontographchild', ['pacient_id' => $nextClientId])
                ->with('success', 'Paciente Registrado Correctamente!');
            }
            
         } catch (\Exception $e) {
            \Log::error('Error Registrando el Paciente: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al Registrar al Paciente. Intente de Nuevo.');
        }
      

    
  
  
    }
    public function destroy($id){
        try{
            $patient = Pacient::findOrFail($id);
            $patient->delete();
            return redirect()->route('patient.index')->with('success', 'Paciente Eliminado Correctamente!');
        } catch (\Exception $e) {
            \Log::error('Error deleting patient: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al Eliminar al Paciente. Intente de Nuevo.');
        }
    }
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');
            if ($query != '') {
                $data = Pacient::where('pacient_id', 'like', '%' . $query . '%')
                    ->orWhere('ars', 'like', '%' . $query . '%')
                    ->orWhere('name', 'like', '%' . $query . '%')
                    ->orWhere('date_of_birth', 'like', '%' . $query . '%')
                    ->orWhere('motive', 'like', '%' . $query . '%')
                    ->orderBy('pacient_id', 'desc')
                    ->get();

                $total_row = $data->count();
                if ($total_row > 0) {
                    foreach ($data as $row) {
                        $output .= '
                        <tr>
                            <td> ' . $row->pacient_id . '</td>
                            <td>' . $row->name . '</td>
                            <td>' . $row->ars . '</td>
                            <td>' . $row->date_of_birth . '</td>
                            <td>' . $row->motive . '</td>
                        </tr>';
                    }
                } else {
                    $output = '
                    <tr>
                        <td align="center" colspan="5"> No Data Found</td>
                    </tr>';
                }
                $data = array(
                    'table_data' => $output,
                );
                echo json_encode($data);
            }
        }
    }
}