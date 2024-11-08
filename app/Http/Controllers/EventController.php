<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Spatie\GoogleCalendar\Event as GoogleCalendarEvent;
use Carbon\Carbon;
use App\Models\Pacient;
use Google\Service\Calendar\EventDateTime;
class EventController extends Controller
{
   

   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();

        return view('event.index', compact('events'));
    }
    public function list()
    {
        $events = Event::all();

        return view('event.list', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Pacient::all();

       return view('event.create',['patients' => $patients] );
    }
    public function edit(string $id){
    try {
        $event = event::where('id', $id)->firstOrFail();
        return view('event.edit', ['Event' => $event]);
    } catch (\Exception $e) {
        \Log::error('Error encontrando Evento para editar: ' . $e->getMessage());
        return response()->json(['error' => 'Datos de Evento no proporcionados.'], 400);
    }
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string',
        'date' => 'required|date|not_in:0000-00-00',
        'dr' =>'required|string',
        'time_from' => 'required',
        'time_to' => 'required|after:time_from',
    ]);

    $timezone = 'America/Santo_Domingo';

    $startDateTime = Carbon::parse($request->input('date') . ' ' . $request->input('time_from'))->setTimezone($timezone);
    
    $endDateTime = Carbon::parse($request->input('date') . ' ' . $request->input('time_to'))->setTimezone($timezone);

    $googleEvent = GoogleCalendarEvent::create([
        'name' => $request->input('title'),
        'startDateTime' => $startDateTime,
        'endDateTime' => $endDateTime,
    ]);
    $event = new Event;
    $event->title = $request->input('title');
    $event->date = Carbon::parse($request->input('date'))->setTimezone($timezone);
    $event->startDateTime = $startDateTime;
    $event->endDateTime = $endDateTime;
    $event->dr = $request->input('dr');
   


    $event->google_event_id = $googleEvent->id;
    $event->save();
    return redirect()->route('events.index')->with('success', 'Evento creado correctamente');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, string $id)
     {
         $request->validate([
             'title' => 'required|string',
             'date' => 'required|date|not_in:0000-00-00',
             'dr' => 'required|string',
             'time_from' => 'required',
             'time_to' => 'required|after:time_from',
         ]);
     
         $timezone = 'America/Santo_Domingo';
         $startDateTime = Carbon::parse($request->input('date') . ' ' . $request->input('time_from'))->setTimezone($timezone);
         $endDateTime = Carbon::parse($request->input('date') . ' ' . $request->input('time_to'))->setTimezone($timezone);
     
         $event = Event::findOrFail($id);
         $event->title = $request->input('title');
         $event->date = $startDateTime->toDateString();
         $event->startDateTime = $startDateTime;
         $event->endDateTime = $endDateTime;
         $event->dr = $request->input('dr');
         $event->save();
     
         if ($event->google_event_id) {
             $googleEvent = Event::find($event->google_event_id);
             if ($googleEvent) {
                 $googleEvent->name = $request->input('title');
                 $googleEvent->startDateTime = $startDateTime;
                 $googleEvent->endDateTime = $endDateTime;
                 $googleEvent->save();
             }
         }
     
         return redirect()->route('events.index')->with('success', 'Evento actualizado correctamente');
     }
     

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
           
            $Event = Event::findOrFail($id);
    
            
            if ($Event->google_event_id) {
                $googleEvent = GoogleCalendarEvent::find($Event->google_event_id);
                if ($googleEvent) {
                    $googleEvent->delete(); 
                }
            }
    
        
            $Event->delete();
    
            return redirect()->route('events.index')->with('success', 'Evento Eliminado Correctamente!');
        } catch (\Exception $e) {
            \Log::error('Error deleting Event: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al Eliminar el Evento. Intente de Nuevo.');
        }
    }
}