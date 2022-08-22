<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\EventStoreRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
                $events = Event::paginate(15);

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
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Invalid input",
                "error" => $validator->getMessageBag()
            ], 400);
        }

        DB::beginTransaction();
        try {
            $event = Event::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'start_at' => $request->start_at,
                'end_at' => $request->end_at
            ]);

            $result = [
                "message" => "Event successfully created",
                "data" => $event
            ];
            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $result = [
                "message" => "Failed to create event",
                "data" => []
            ];
            return response()->json($result, 400);
        }
    }

    public function show($id)
    {
        try {
            $event = Event::findOrFail($id);
            $result = [
                "message" => "Event successfully retrived",
                "data" => $event
            ];
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result = [
                "message" => "Failed to retrive events",
                "data" => null
            ];
            return response()->json($result, 400);
        }
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Invalid input",
                "error" => $validator->getMessageBag()
            ], 400);
        }

        DB::beginTransaction();
        try {
            $event = Event::updateOrCreate([
                'id' => $id
            ], [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'start_at' => $request->start_at,
                'end_at' => $request->end_at
            ]);

            $result = [
                "message" => "Event successfully updated",
                "data" => $event
            ];
            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $result = [
                "message" => $th,
                "data" => null
            ];
            return response()->json($result, 400);
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
            DB::commit();

            if($request->wantsJson()){
                return response()->json($result, 200);
            }else{
                return back()->with('success', "Event $event_name successfully destroyed");
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            $result = [
                "message" => "Failed to destroy events",
            ];

            if($request->wantsJson()){
                return response()->json($result, 400);
            }else{
                return back()->with('success', "Failed to destroy events");
            }

        }
    }
}
