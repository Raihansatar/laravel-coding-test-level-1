<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        try {
            $events = Event::all();
            $result = [
                "message" => "Events successfully retrived",
                "data" => $events
            ];
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            $result = [
                "success" => 400,
                "message" => "Failed to retrive events",
                "data" => []
            ];
            return response()->json($result, 400);
        }
    }

    public function activeEvent()
    {
        $now = now();

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
                "success" => 400,
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
        DB::beginTransaction();
        try {
            $event = Event::create($request->all());
            $result = [
                "message" => "Event successfully created",
                "data" => $event
            ];
            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $result = [
                "success" => 500,
                "message" => $th->getMessage(),
                // "message" => "Failed to create event",
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
        DB::beginTransaction();
        try {
            $event = Event::updateOrCreate([
                'id' => $id
            ], $request->all());

            $result = [
                "message" => "Event successfully updated",
                "data" => $event
            ];
            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $result = [
                "message" => "Failed to update events",
                "data" => null
            ];
            return response()->json($result, 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Event::findOrFail($id)->delete();
            $result = [
                "message" => "Event successfully destroyed",
            ];
            DB::commit();
            return response()->json($result, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            $result = [
                "message" => "Failed to destroy events",
            ];
            return response()->json($result, 400);
        }
    }
}
