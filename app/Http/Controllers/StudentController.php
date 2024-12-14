<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function checkStudentId(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string|max:10', // ปรับตามความยาวของรหัสนิสิต
        ]);

        $exists = Student::where('student_id', $request->student_id)->exists();

        return response()->json(['exists' => $exists]);
    }
}
