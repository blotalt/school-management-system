<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSection;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ClassSectionController extends Controller
{
    public function index()
    {
        $classes = ClassSection::with(['course', 'teacher.user'])->paginate(15);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $courses  = Course::orderBy('name')->get();
        $teachers = Teacher::with('user')->get();
        return view('admin.classes.create', compact('courses', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room'       => 'required|string|max:50',
            'day'        => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'capacity'   => 'required|integer|min:1',
        ]);

        $teacherConflict = ClassSection::where('day', $request->day)
            ->where('teacher_id', $request->teacher_id)
            ->where('start_time', '<', $request->end_time)
            ->where('end_time', '>', $request->start_time)
            ->exists();

        if ($teacherConflict) {
            return back()->withErrors(['teacher_id' => 'This teacher already has a class at this time.'])->withInput();
        }

        $roomConflict = ClassSection::where('day', $request->day)
            ->where('room', $request->room)
            ->where('start_time', '<', $request->end_time)
            ->where('end_time', '>', $request->start_time)
            ->exists();

        if ($roomConflict) {
            return back()->withErrors(['room' => 'This room is already occupied at this time.'])->withInput();
        }

        ClassSection::create($request->only('course_id', 'teacher_id', 'room', 'day', 'start_time', 'end_time', 'capacity'));

        return redirect()->route('admin.classes.index')->with('success', 'Class section created successfully.');
    }

    public function edit(ClassSection $class)
    {
        $courses  = Course::orderBy('name')->get();
        $teachers = Teacher::with('user')->get();
        return view('admin.classes.edit', compact('class', 'courses', 'teachers'));
    }

    public function update(Request $request, ClassSection $class)
    {
        $request->validate([
            'course_id'  => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room'       => 'required|string|max:50',
            'day'        => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'capacity'   => 'required|integer|min:1',
        ]);

        $teacherConflict = ClassSection::where('day', $request->day)
            ->where('teacher_id', $request->teacher_id)
            ->where('id', '!=', $class->id)
            ->where('start_time', '<', $request->end_time)
            ->where('end_time', '>', $request->start_time)
            ->exists();

        if ($teacherConflict) {
            return back()->withErrors(['teacher_id' => 'This teacher already has a class at this time.'])->withInput();
        }

        $roomConflict = ClassSection::where('day', $request->day)
            ->where('room', $request->room)
            ->where('id', '!=', $class->id)
            ->where('start_time', '<', $request->end_time)
            ->where('end_time', '>', $request->start_time)
            ->exists();

        if ($roomConflict) {
            return back()->withErrors(['room' => 'This room is already occupied at this time.'])->withInput();
        }

        $class->update($request->only('course_id', 'teacher_id', 'room', 'day', 'start_time', 'end_time', 'capacity'));

        return redirect()->route('admin.classes.index')->with('success', 'Class section updated successfully.');
    }

    public function destroy(ClassSection $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class section deleted successfully.');
    }
}
