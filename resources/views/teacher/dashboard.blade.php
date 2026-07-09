@extends('layouts.sms')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-6">Teacher Dashboard</h2>

@php
    $teacher  = auth()->user()->teacher;
    $sections = $teacher ? $teacher->classSections()->with('course')->get() : collect();
@endphp

<div class="bg-white rounded shadow-sm p-5 mb-6 max-w-sm">
    <p class="text-sm text-gray-500">Welcome back,</p>
    <p class="text-lg font-semibold">{{ auth()->user()->name }}</p>
    @if($teacher)
        <p class="text-sm text-gray-500 mt-1">{{ $teacher->department ?? 'No department' }} &middot; {{ $teacher->employee_code }}</p>
    @endif
</div>

<h3 class="text-base font-semibold text-gray-700 mb-3">My Classes</h3>

<div class="bg-white rounded shadow-sm overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 text-left">
            <tr>
                <th class="px-4 py-3">Course</th>
                <th class="px-4 py-3">Room</th>
                <th class="px-4 py-3">Day</th>
                <th class="px-4 py-3">Time</th>
                <th class="px-4 py-3">Capacity</th>
                <th class="px-4 py-3">Enrolled</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($sections as $section)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $section->course->name }}</td>
                <td class="px-4 py-3">{{ $section->room }}</td>
                <td class="px-4 py-3">{{ $section->day }}</td>
                <td class="px-4 py-3">{{ $section->start_time }} - {{ $section->end_time }}</td>
                <td class="px-4 py-3">{{ $section->capacity }}</td>
                <td class="px-4 py-3">{{ $section->enrolledCount() }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-400">No classes assigned yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
