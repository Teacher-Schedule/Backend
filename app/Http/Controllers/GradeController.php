<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $grade = Grade::create([
            'student_id' => $request->student_id,
            'lab_id' => $request->lab_id,
            'grade' => $request->grade,
            'description' => $request->description
        ]);

        return response()->json($grade);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $student = Grade::find($id);
        if(!$student) {
            return response()->json([
                'message' => 'Оценка не найдена'
            ]);
        }

        return response()->json($student);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $grade = Grade::findOrFail($id);
        $grade->lab_id = $request->lab_id;
        $grade->student_id = $request->student_id;
        $grade->grade = $request->grade;
        $grade->description = $request->description;
        $grade->save();

        return response()->json($grade, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        Grade::findOrFail($id)->delete();

        return response()->json([ 'status' => true ],200);
    }
}
