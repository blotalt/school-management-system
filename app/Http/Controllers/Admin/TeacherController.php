<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->paginate(15);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:8|confirmed',
            'employee_code' => 'required|string|unique:teachers,employee_code',
            'phone'         => 'nullable|string|max:20',
            'department'    => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'teacher',
        ]);

        Teacher::create([
            'user_id'       => $user->id,
            'employee_code' => $request->employee_code,
            'phone'         => $request->phone,
            'department'    => $request->department,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $teacher->user_id,
            'employee_code' => 'required|string|unique:teachers,employee_code,' . $teacher->id,
            'phone'         => 'nullable|string|max:20',
            'department'    => 'nullable|string|max:100',
        ]);

        $teacher->user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $teacher->update([
            'employee_code' => $request->employee_code,
            'phone'         => $request->phone,
            'department'    => $request->department,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->user->delete();
        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
