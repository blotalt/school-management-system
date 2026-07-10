<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->latest()->paginate(15);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'student_no' => ['required', 'string', 'max:50', 'unique:students,student_no'],
            'enrollment_date' => ['nullable', 'date'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $user->id,
            'student_no' => $validated['student_no'],
            'enrollment_date' => $validated['enrollment_date'] ?? null,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    public function edit(Student $student)
    {
        $student->load('user');
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($student->user_id)],
            'password' => ['nullable', 'string', 'min:6'],
            'student_no' => ['required', 'string', 'max:50', Rule::unique('students', 'student_no')->ignore($student->id)],
            'enrollment_date' => ['nullable', 'date'],
        ]);

        $student->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            ...(!empty($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
        ]);

        $student->update([
            'student_no' => $validated['student_no'],
            'enrollment_date' => $validated['enrollment_date'] ?? null,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        // Deleting the user cascades to the student row (cascadeOnDelete on the FK)
        User::destroy($student->user_id);

        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}