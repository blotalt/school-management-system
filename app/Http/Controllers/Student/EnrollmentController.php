<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassSection;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $availableClasses = ClassSection::with(['course', 'teacher.user'])->get();
        $myEnrollments = auth()->user()->student->enrollments()
            ->with('classSection.course')
            ->where('status', 'active')
            ->get();

        return view('student.enrollments.index', compact('availableClasses', 'myEnrollments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => ['required', 'exists:classes,id'],
        ]);

        $student = auth()->user()->student;
        $class = ClassSection::findOrFail($validated['class_id']);

        // Capacity check
        if (! $class->hasAvailableSeats()) {
            return back()->with('error', 'This class is full.');
        }

        // Duplicate enrollment check (also enforced by DB unique constraint)
        $alreadyEnrolled = Enrollment::where('student_id', $student->id)
            ->where('class_id', $class->id)
            ->where('status', 'active')
            ->exists();

        if ($alreadyEnrolled) {
            return back()->with('error', 'You are already enrolled in this class.');
        }

        // Schedule conflict check: same day, overlapping time
        $conflict = $student->enrollments()
            ->where('status', 'active')
            ->whereHas('classSection', function ($query) use ($class) {
                $query->where('day_of_week', $class->day_of_week)
                    ->where('start_time', '<', $class->end_time)
                    ->where('end_time', '>', $class->start_time);
            })
            ->exists();

        if ($conflict) {
            return back()->with('error', 'This class overlaps with one you are already enrolled in.');
        }

        Enrollment::create([
            'student_id' => $student->id,
            'class_id' => $class->id,
            'status' => 'active',
        ]);

        return back()->with('success', 'Enrolled successfully.');
    }

    public function destroy(Enrollment $enrollment)
    {
        // Make sure students can only drop their own enrollment
        abort_unless($enrollment->student_id === auth()->user()->student->id, 403);

        $enrollment->update(['status' => 'dropped']);

        return back()->with('success', 'Dropped the class.');
    }
}