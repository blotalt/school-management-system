<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->paginate(15);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:8|confirmed',
            'student_code'  => 'required|string|unique:students,student_code',
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string',
            'date_of_birth' => 'nullable|date',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'student',
        ]);

        Student::create([
            'user_id'       => $user->id,
            'student_code'  => $request->student_code,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $student->user_id,
            'student_code'  => 'required|string|unique:students,student_code,' . $student->id,
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string',
            'date_of_birth' => 'nullable|date',
        ]);

        $student->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $student->update([
            'student_code'  => $request->student_code,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->user->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}
