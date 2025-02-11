<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $student = Student::create([
            'name' => $request->name,
            'group_id' => $request->group_id
        ]);

        return response()->json(new StudentResource($student), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::find($id);
        if(!$student) {
            return response()->json([
                'message' => 'Студент не найден'
            ]);
        }

        return response()->json(new StudentResource($student), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);
        $student->name = $request->name;
        $student->group_id = $request->group_id;


        $student->save();

        return response()->json(new StudentResource($student), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Student::findOrFail($id)->delete();

        return response()->json([ 'status' => true ],200);
    }

    public function loadStudents(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['message' => 'Файл не загружен'], 400);
        }

        $file = $request->file('file');

        if ($file->getClientOriginalExtension() !== 'json') {
            return response()->json(['message' => 'У файла тип не .json'], 400);
        }

        $content = file_get_contents($file->getRealPath());
        $data = json_decode($content, true);

        foreach ($data as $student) {
            Student::create([
                'name' => $student['ФИО'],
                'group_id' => $request->group_id
            ]);
        }

        return response()->json(['success' => true], 200);
    }
}
