<?php

namespace App\Http\Controllers;

use App\Mail\EventCreatedMail;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function index(Request $request)
    {
        if($request->wantsJson()){
            try {
                $events = Event::all();
                $result = [
                    "message" => "Events successfully retrived",
                    "data" => $events
                ];
                return response()->json($result, 200);

            } catch (\Throwable $th) {
                $result = [
                    "message" => "Failed to retrive events",
                    "data" => []
                ];
                return response()->json($result, 400);
            }
        }else{
            try {
                $per_page = 10;
                if($request->per_page){
                    $per_page = $request->per_page;
                }

                $events = Event::
                    when($request->name, function ($query) use($request) {
                        $query->where('name', 'LIKE', '%'.$request->name.'%');
                    })
                    // filter date by get the active based on the date
                    ->when($request->date, function ($query) use($request) {
                        $date = Carbon::parse($request->date);
                        $query
                            ->where('start_at', '<=', $date)
                            ->where('end_at', '>=', $date);
                    })
                    ->paginate($per_page)->withQueryString();

                return view('event.index', compact('events'));
            } catch (\Throwable $th) {
                abort(404);
            }

        }
    }

    public function activeEvent()
    {
        $now = now('Asia/Kuala_Lumpur');

        try {
            $events = Event::where('start_at', '<=', $now)
                ->where('end_at', '>=', $now)
                ->get();

            $result = [
                "message" => "Events successfully retrived",
                "data" => $events
            ];
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result = [
                "message" => "Failed to retrive events",
                "data" => []
            ];
            return response()->json($result, 400);
        }
    }

    public function create()
    {
        return view('event.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'unique:events,slug',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
        ]);

        if ($validator->fails()) {
            if($request->wantsJson()){
                return response()->json([
                    "message" => "Invalid input",
                    "error" => $validator->getMessageBag()
                ], 400);
            }else{
                return back()->withErrors($validator);
            }
        }

        DB::beginTransaction();
        try {

            if($request->slug){
                $slug = $request->slug;
            }else{
                $count = Event::where('name', $request->name)->count();
                $slug = ($count == 0)
                    ? Str::slug($request->name)
                    : Str::slug($request->name.'-'.$count);
            }

            $event = Event::create([
                'name' => $request->name,
                'slug' => $slug,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at
            ]);

            Mail::to($request->user())->send(new EventCreatedMail($event, auth()->user()->name));

            Redis::set("event-$event->id", $event);

            $result = [
                "message" => "Event successfully created",
                "data" => $event
            ];
            DB::commit();

            return $request->wantsJson()
                ? response()->json($result, 200)
                : redirect()
                    ->route('event.show', ['id' => $event->id])
                    ->with('success', "Event $event->name successfully created");

        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            $result = [
                "message" => "Failed to create event",
                "data" => []
            ];

            return $request->wantsJson()
                ? response()->json($result, 400)
                : back()->with('error', "Failed to create event");
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $cachedEvent = Redis::get("event-$id");

            if(isset($cachedEvent)){
                $event = json_decode($cachedEvent);

                // map date to carbon format
                $event->start_at = Carbon::parse($event->start_at);
                $event->end_at = Carbon::parse($event->end_at);

            }else{
                $event = Event::findOrFail($id);

                Redis::set("event-$event->id", $event);
            }

            $result = [
                "message" => "Event successfully retrived",
                "data" => $event
            ];

            return $request->wantsJson()
                ? response()->json($result, 200)
                : view('event.show', compact('event'));

        } catch (\Throwable $th) {
            $result = [
                "message" => "Failed to retrive events",
                "data" => null
            ];

            return $request->wantsJson()
                ? response()->json($result, 400)
                : back()
                    ->with('error', "Failed to retrive events");

        }
    }

    public function edit($id)
    {
        $cachedEvent = Redis::get("event-$id");

        if(isset($cachedEvent)){
            $event = json_decode($cachedEvent);

            // map date to carbon format
            $event->start_at = Carbon::parse($event->start_at);
            $event->end_at = Carbon::parse($event->end_at);
        }else{
            $event = Event::findOrFail($id);
            Redis::set("event-$event->id", $event);
        }

        return view('event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => Rule::unique('events', 'slug')->ignore($id),
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
        ]);

        if ($validator->fails()) {
            if($request->wantsJson()){
                return response()->json([
                    "message" => "Invalid input",
                    "error" => $validator->getMessageBag()
                ], 400);
            }else{
                return back()->withErrors($validator);
            }
        }

        DB::beginTransaction();
        try {
            if($request->slug){
                $slug = $request->slug;
            }else{
                $count = Event::where('name', $request->name)->count();
                $slug = ($count == 0)
                    ? Str::slug($request->name)
                    : Str::slug($request->name.'-'.$count);
            }

            $event = Event::updateOrCreate([
                'id' => $id
            ], [
                'name' => $request->name,
                'slug' => $slug,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at
            ]);

            Redis::del("event-$event->id");
            Redis::set("event-$event->id", $event);

            $result = [
                "message" => "Event $event->name successfully updated",
                "data" => $event
            ];
            DB::commit();

            return $request->wantsJson()
                ? response()->json($result, 200)
                : redirect()
                    ->route('event.show', ['id' => $event->id])
                    ->with('success', "Event $event->name successfully updated");

        } catch (\Throwable $th) {
            DB::rollBack();
            $result = [
                "message" => "Failed to update event",
                "data" => null
            ];

            return $request->wantsJson()
                ? response()->json($result, 400)
                : back()->with('error', "Failed $event->name to update event");

        }
    }

    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $event = Event::findOrFail($id);
            $event_name = $event->name;
            $event->delete();
            $result = [
                "message" => "Event $event_name successfully destroyed",
            ];

            Redis::del("event-$id");
            DB::commit();

            return $request->wantsJson()
                ? response()->json($result, 200)
                : back()->with('success', "Event $event_name successfully destroyed");

        } catch (\Throwable $th) {
            DB::rollBack();
            $result = [
                "message" => "Failed to destroy events",
            ];

            return $request->wantsJson()
                ? response()->json($result, 400)
                : back()->with('error', "Failed to destroy events");

        }
    }
}
