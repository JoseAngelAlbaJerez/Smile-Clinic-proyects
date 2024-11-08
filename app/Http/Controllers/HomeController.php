<?php

namespace App\Http\Controllers;

use App\Models\Pettycash;
use Illuminate\Http\Request;
use App\Models\Pacient;
use App\Models\Event;
use App\Models\Abono;
use App\Models\Budget;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalPatients = Pacient::count();
        $sixMonthsAgo = Carbon::now()->subMonths(6);
        $patientsToCall = Event::whereDate('date', '<', $sixMonthsAgo)->count();
        $abonos = Abono::sum('abonar');
        $budgets = Budget::sum('Total');
        $income = $abonos + $budgets;
        $expenses = Pettycash::sum('amount');
        
        $totalAppointments = Event::whereDate('date', today())->count();
        $startDateTime = Carbon::today();
        $endDateTime = Carbon::today()->addDays(2);
        $totalAppointmentsNextTwoDays = Event::whereBetween('date', [
            Carbon::today(),
            Carbon::today()->addDays(2)
        ])->get();
      
        $totalAppointmentsNextTwoDayscount = Event::whereBetween('date', [$startDateTime, $endDateTime])->count();
    
        return view('home', compact('totalPatients','patientsToCall', 'totalAppointments','totalAppointmentsNextTwoDays','income','expenses','totalAppointmentsNextTwoDayscount'));
    }
}
