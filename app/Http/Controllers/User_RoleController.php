<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class User_RoleController extends Controller
{
    public function index(){
        
        return view('user.index');
    }
}
