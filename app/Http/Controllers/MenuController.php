<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class MenuController extends Controller
{
    public static function GetMenuUser($userId)
    {
        // Obtener el id del perfil del usuario
        $menus = DB::table('module')
            ->join('profile_module', 'module.id', '=', 'profile_module.id_module')
            ->join('profile', 'profile.id', '=', 'profile_module.id_profile')
            ->join('users', 'users.id_profile_user', '=', 'profile.id')
            ->where('users.id', $userId) // Filtrar por el ID del usuario
            ->where('profile_module.status', 1) // Asegurar que el módulo esté activo
            ->select('module.*', 'profile_module.view_start as view_start')
            ->orderBy('module.order')
            ->get();
        
        // Cargar submenús
        foreach ($menus as $menu) {
            $menu->children = DB::table('module')
                ->where('father_id', $menu->id)
                ->orderBy('order')
                ->get();
        }
    
        // Asignar la ruta completa al menú
        foreach ($menus as $menu) {
            // Verificar si el campo 'view' tiene un valor válido
            if (empty($menu->view)) {
                $menu->view = '/app/dashboard'; // Default view in case it's empty
            } else {
                $menu->view = '/app/' . ltrim($menu->view, '/');
            }
        }
    
        return $menus;
    }
    
    
    
    
    public static function GetSubMenuUser($idMenu, $IdUser)
    {
        $subMenu = \DB::table('module as m')
            ->join('profile_module as pm', 'm.id', '=', 'pm.id_module')
            ->join('profile as p', 'pm.id_profile', '=', 'p.id_profile')
            ->join('users as u', 'u.id_profile_user', '=', 'p.id_profile')
            ->where('u.id', $IdUser)
            ->where('m.father_id', $idMenu)
            ->select('m.id', 'm.module', 'm.icon_menu', 'm.view', 'pm.view_start')
            ->orderBy('m.order')
            ->get();

        return $subMenu;
    }
}
