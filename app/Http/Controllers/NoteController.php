<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(NoteResource::collection(Note::all()), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $note = Note::create([
            'title' => $request->title,
            'description' => $request->description,
            'group_id' => $request->group_id,
        ]);

        return response()->json(new NoteResource($note));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $note = Note::find($id);
        if(!$note) {
            return response()->json([
                'message' => 'Заметка не найдена'
            ]);
        }

        return response()->json(new NoteResource($note));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $note = Note::findOrFail($id);
        $note->title = $request->title;
        $note->group_id = $request->group_id;
        $note->description = $request->description;
        $note->save();

        return response()->json(new NoteResource($note), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Note::findOrFail($id)->delete();

        return response()->json([ 'status' => true ],200);
    }
}
