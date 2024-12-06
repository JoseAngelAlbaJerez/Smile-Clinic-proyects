<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    public function load()
    {
        $query = "
           SELECT 
                '' AS opciones,
                id,
                `order`,
                module,
                (SELECT module FROM module mp WHERE mp.id = m.father_id) AS modulo_padre,
                view,
                icon_menu,
                DATE(created_at) AS created_at,
                DATE(updated_at) AS updated_at
           FROM module m
           ORDER BY `order`;
        ";
    
        $result = DB::select($query);
    
        // Formatea la respuesta en JSON con la clave `data`
        return response()->json(['data' => $result]);
    }
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'module' => 'required|string',
                'father_id' => 'required|numeric',
                'view' => 'required|string',
                'icon_menu' => 'required|string',
                'order' => 'required|numeric',
            ]);
            DB::table('profile')->insert([
                'module' => $validatedData['module'],
                'father_id' => $validatedData['father_id'],
                'view' => $validatedData['view'],
                'icon_menu' => $validatedData['icon_menu'],
                'order' => $validatedData['order'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

         
         
    
            
    
            return redirect()->route('user.index')
            ->with('success', 'Modulo Registrado Correctamente!');
    } catch (\Exception $e) {
        // Registrar el error en el log
        \Log::error('Error Registrando el Modulo: ' . $e->getMessage());

        // Redirigir con mensaje de error
        return redirect()->back()
            ->with('error', 'Error al Registrar el Modulo. Intente de Nuevo.');
    }

   
    }
    public function delete($id)
    {
        try {
            // Eliminar el registro con el ID especificado
            DB::table('module')->where('id', $id)->delete();
    
            // Redirigir con mensaje de éxito
            return redirect()->route('user.index')
                ->with('success', 'Modulo Eliminado Correctamente!');
        } catch (\Exception $e) {
            // Registrar el error en el log
            \Log::error('Error Eliminando el Modulo: ' . $e->getMessage());
    
            // Redirigir con mensaje de error
            return redirect()->back()
                ->with('error', 'Error al Eliminar el Modulo. Intente de Nuevo.');
        }
    }
    
    public function GetModules(){
        $query = "select id as id,
                                                        (case when (father_id is null or father_id = 0)then '#' else father_id end) as parent,
                                                        module as text,
                                                        view
                                                from module m
                                                order by m.order";
                                    
    $result = DB::select($query);
    
    
    return $result;

    }

    static public function OrganizeModules($organized_modules){        

        $total_registres = 0;

        foreach($organized_modules as $modules){
            
            $array_item_modules = explode(";",$modules);

            $stmt = DB::update("UPDATE module
                                                    SET padre_id = replace(:p_padre_id,'#',0),
                                                        orden = :p_orden
                                                    WHERE id = :p_id");

            $stmt -> bindParam(":p_id",$array_item_modules[0],PDO::PARAM_INT);            
            $stmt -> bindParam(":p_padre_id",$array_item_modules[1],PDO::PARAM_INT);
            $stmt -> bindParam(":p_orden",$array_item_modules[2],PDO::PARAM_INT);

            if($stmt->execute()){
                $total_registres = $total_registres + 1;
            }else{
                $total_registres = 0;
            }

        }        

        return $total_registres;

    }
}
