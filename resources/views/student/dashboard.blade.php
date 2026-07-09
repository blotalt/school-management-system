@extends('layouts.sms')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-6">Student Dashboard</h2>

@php
    $student  = auth()->user()->student;
    $enrolled = $student ? $student->classSections()->with(['course', 'teacher.user'])->get() : collect();
@endphp

<div class="bg-white rounded shadow-sm p-5 mb-6 max-w-sm">
    <p class="text-sm text-gray-500">Welcome back,</p>
    <p class="text-lg font-semibold">{{ auth()->user()->name }}</p>
    @if($student)
        <p class="text-sm text-gray-500 mt-1">{{ $student->student_code }}</p>
    @endif
</div>

<div class="flex justify-between items-center mb-3">
    <h3 class="text-base font-semibold text-gray-700">My Enrolled Classes</h3>
</div>

<div class="bg-white rounded shadow-sm overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 text-left">
            <tr>
                <th class="px-4 py-3">Course</th>
                <th class="px-4 py-3">Teacher</th>
                <th class="px-4 py-3">Room</th>
                <th class="px-4 py-3">Day</th>
                <th class="px-4 py-3">Time</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($enrolled as $section)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $section->course->name }}</td>
                <td class="px-4 py-3">{{ $section->teacher->user->name }}</td>
                <td class="px-4 py-3">{{ $section->room }}</td>
                <td class="px-4 py-3">{{ $section->day }}</td>
                <td class="px-4 py-3">{{ $section->start_time }} - {{ $section->end_time }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-6 text-center text-gray-400">Not enrolled in any classes yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
