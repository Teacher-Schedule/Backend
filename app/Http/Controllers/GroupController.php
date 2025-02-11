<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(GroupResource::collection(Auth::user()->groups), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GroupRequest $request)
    {
        $group = Group::create([
            'title' => $request->title,
            'user_id' => Auth::id()
        ]);

        if ($request->has('lab_ids')) {
            $group->labs()->attach($request->lab_ids);
        }


        return response()->json(new GroupResource($group));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = Group::find($id);
        if(!$group) {
            return response()->json([
                'message' => 'Группа не найдена'
            ]);
        }

        return response()->json(new GroupResource($group));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group = Group::findOrFail($id);

        $group->fill($request->only(['title']));

        if ($request->has('lab_ids')) {
            $group->labs()->sync($request->lab_ids);
        }

        $group->save();

        return response()->json(new GroupResource($group));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Group::find($id)->delete();

        return response()->json([ 'status' => true ], 200);
    }
}
