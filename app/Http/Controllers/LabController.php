<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabRequest;
use App\Http\Resources\LabResource;
use App\Models\Lab;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(LabResource::collection(Lab::all()), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LabRequest $request)
    {
        $lab = Lab::create([
            'title' => $request->title,
        ]);

        if ($request->has('group_ids')) {
            $lab->groups()->attach($request->group_ids);
        }

        return response()->json($lab, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lab = Lab::find($id);
        if(!$lab) {
            return response()->json([
                'message' => 'Работа не найдена'
            ]);
        }

        return response()->json($lab);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LabRequest $request, string $id)
    {
        $lab = Lab::findOrFail($id);
        $lab->title = $request->title;

        if ($request->has('group_ids')) {
            $lab->groups()->sync($request->group_ids);
        } else {
            $lab->groups()->detach();
        }

        $lab->save();

        return response()->json($lab, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Lab::findOrFail($id)->delete();

        return response()->json([ 'status' => true ],200);
    }
}
