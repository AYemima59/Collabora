<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Rating;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //
    function index() {
        $event = Event::where('account_id', session('account')->id)->get();
        return view('event/index', ['eventList' => $event]);
        // $search = $request->search;
        // $event = event::where('name_event', 'LIKE', '%'.$search.'%')->get();
    }
    function adminEvent(){
        $event = Event::all();
        return view('event/index', ['eventList' => $event]);
    }

    function search(Request $request) {
        $event = Event::all();
        $search = $request->search;
        $event = event::where('name_event', 'LIKE', '%'.$search.'%')->get();
        return view('event/index', ['eventList' => $event]);
    }

    function create() {
        $class = event::all();
        return view ('page/create-event', ['class' => $class]);
    }

    function store(Request $request) {
        // $filePath = 'null';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('event', $filename, 'public');
        }
        $event = new event;
        $event->name_event = $request->name_event;
        $event->location = $request->location;
        $event->date = $request->date;
        $event->description_event = $request->description_event;
        $event->event_image = $filePath ?? null;
        $event->account_id = session('account')->id;
        $event->save();
        return redirect('/event');
    }

    public function show($id)
    {
        $event = Event::find($id);
        $avgRating = Rating::where('event_id', $event->id)->avg('star');
    
        return view('page/event-show', compact('event', 'avgRating'));
    }
    

    function edit($id) {
        $event = Event::find($id);
        return view('page/event-edit', [
            'eventList' => $event
        ]);
    }
    public function update(Request $request, $id)
    {
        // Validate and update the event data
        $request->validate([
            'name_event' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'description_event' => 'required|string',
            'image' => 'nullable|image|max:2048', // Example validation for image upload
        ]);

        $event = Event::findOrFail($id);
        $event->name_event = $request->input('name_event');
        $event->location = $request->input('location');
        $event->date = $request->input('date');
        $event->description_event = $request->input('description_event');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('event_images', 'public');
            $event->event_image = $imagePath;
        }

        $event->save();

        return response()->json([
            'message' => 'Event updated successfully!',
            'data' => $event
        ]);
    }

    public function destroy($id) {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect('/event');
    }
}
