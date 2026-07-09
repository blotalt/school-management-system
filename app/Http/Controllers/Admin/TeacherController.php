<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->latest()->paginate(15);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'employee_no' => ['required', 'string', 'max:50', 'unique:teachers,employee_no'],
            'department' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'employee_no' => $validated['employee_no'],
            'department' => $validated['department'] ?? null,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user');
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($teacher->user_id)],
            'password' => ['nullable', 'string', 'min:6'],
            'employee_no' => ['required', 'string', 'max:50', Rule::unique('teachers', 'employee_no')->ignore($teacher->id)],
            'department' => ['nullable', 'string', 'max:100'],
        ]);

        $teacher->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            ...(!empty($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
        ]);

        $teacher->update([
            'employee_no' => $validated['employee_no'],
            'department' => $validated['department'] ?? null,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        User::destroy($teacher->user_id);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}