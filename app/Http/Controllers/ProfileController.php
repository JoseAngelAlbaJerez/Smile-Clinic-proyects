<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProfileController extends Controller
{
    public function load()
    {
        $profiles = DB::table('profile')
            ->select('id', 'description', 'status', 'created_at', 'updated_at')
            ->get();
    
        return response()->json(['data' => $profiles]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'description' => 'required|string',
                'status' => 'required|numeric',
                
            ]);
            DB::table('profile')->insert([
                'description' => $validatedData['description'],
                'status' => $validatedData['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

         
         
    
            
    
            return redirect()->route('user.index')
            ->with('success', 'Perfil Registrado Correctamente!');
    } catch (\Exception $e) {
        // Registrar el error en el log
        \Log::error('Error Registrando el Perfil: ' . $e->getMessage());

        // Redirigir con mensaje de error
        return redirect()->back()
            ->with('error', 'Error al Registrar el Perfil. Intente de Nuevo.');
    }

   
    }
    public function delete($id)
    {
        try {
            // Eliminar el registro con el ID especificado
            DB::table('profile')->where('id', $id)->delete();
    
            // Redirigir con mensaje de éxito
            return redirect()->route('user.index')
                ->with('success', 'Perfil Eliminado Correctamente!');
        } catch (\Exception $e) {
            // Registrar el error en el log
            \Log::error('Error Eliminando el Perfil: ' . $e->getMessage());
    
            // Redirigir con mensaje de error
            return redirect()->back()
                ->with('error', 'Error al Eliminar el Perfil. Intente de Nuevo.');
        }
    }
    
    public function GetModulesByProfile(Request $request)
    {
        $id_profile = $request->input('id_profile');
        if (!$id_profile) {
            return response()->json(['error' => 'El ID del perfil es obligatorio'], 400);
        }
    
        $query = "
            SELECT 
                id,
                module,
                IFNULL(
                    CASE 
                        WHEN (m.view IS NULL OR m.view = '') THEN '0' 
                        ELSE (
                            SELECT '1' 
                            FROM profile_module pm 
                            WHERE pm.id_module = m.id 
                              AND pm.id_profile = :id_profile
                        ) 
                    END, 
                    0
                ) as sel
            FROM module m
            ORDER BY m.order
        ";
    
        $result = DB::select($query, ['id_profile' => $id_profile]);
        return response()->json($result);
    }

    public function storeprofile_modules($idPerfil, $array_idModulos, $id_modulo_inicio, &$total_registros){
        

        $total_registros = 0;
        
        // Iniciar una transacción para garantizar atomicidad
        DB::transaction(function () use ($idPerfil, $array_idModulos, $id_modulo_inicio, &$total_registros) {
            // Eliminar registros previos según la condición
            if ($idPerfil == 1) {
                DB::table('perfil_modulo')
                    ->where('id_perfil', $idPerfil)
                    ->where('id_modulo', '!=', 13)
                    ->delete();
            } else {
                DB::table('perfil_modulo')
                    ->where('id_perfil', $idPerfil)
                    ->delete();
            }
        
            // Iterar sobre los módulos y realizar las inserciones
            foreach ($array_idModulos as $value) {
                if ($idPerfil == 1 && $value == 13) {
                    continue; // Saltar este caso
                }
        
                $vista_inicio = ($value == $id_modulo_inicio) ? 1 : 0;
        
                // Insertar el nuevo registro
                $inserted = DB::table('perfil_modulo')->insert([
                    'id_perfil' => $idPerfil,
                    'id_modulo' => $value,
                    'vista_inicio' => $vista_inicio,
                    'estado' => 1,
                ]);
        
                // Incrementar el contador solo si la inserción fue exitosa
                $total_registros += $inserted ? 1 : 0;
            }
    });
        
        
    }


    
}
