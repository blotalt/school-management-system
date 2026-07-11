<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSection;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['student.user', 'classSection.course'])
            ->latest()
            ->paginate(15);

        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = Student::with('user')->get();
        $classes = ClassSection::with('course')->get();

        return view('admin.enrollments.create', compact('students', 'classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'class_id' => ['required', 'exists:classes,id'],
        ]);

        $student = Student::findOrFail($validated['student_id']);
        $class = ClassSection::findOrFail($validated['class_id']);

        if (! $class->hasAvailableSeats()) {
            return back()->withInput()->with('error', 'This class is full.');
        }

        $alreadyEnrolled = Enrollment::where('student_id', $student->id)
            ->where('class_id', $class->id)
            ->where('status', 'active')
            ->exists();

        if ($alreadyEnrolled) {
            return back()->withInput()->with('error', 'This student is already enrolled in this class.');
        }

        $conflict = $student->enrollments()
            ->where('status', 'active')
            ->whereHas('classSection', function ($query) use ($class) {
                $query->where('day_of_week', $class->day_of_week)
                    ->where('start_time', '<', $class->end_time)
                    ->where('end_time', '>', $class->start_time);
            })
            ->exists();

        if ($conflict) {
            return back()->withInput()->with('error', 'This class overlaps with one the student is already enrolled in.');
        }

        Enrollment::create([
            'student_id' => $student->id,
            'class_id' => $class->id,
            'status' => 'active',
        ]);

        return redirect()->route('admin.enrollments.index')->with('success', 'Student enrolled successfully.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->update(['status' => 'dropped']);

        return back()->with('success', 'Enrollment dropped.');
    }
}