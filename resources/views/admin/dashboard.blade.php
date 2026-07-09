@extends('layouts.sms')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-6">Admin Dashboard</h2>

@php
    $students = \App\Models\Student::count();
    $teachers = \App\Models\Teacher::count();
    $courses  = \App\Models\Course::count();
    $classes  = \App\Models\ClassSection::count();
@endphp

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="bg-white rounded shadow-sm p-5 text-center">
        <p class="text-3xl font-bold text-blue-600">{{ $students }}</p>
        <p class="text-sm text-gray-500 mt-1">Students</p>
    </div>
    <div class="bg-white rounded shadow-sm p-5 text-center">
        <p class="text-3xl font-bold text-green-600">{{ $teachers }}</p>
        <p class="text-sm text-gray-500 mt-1">Teachers</p>
    </div>
    <div class="bg-white rounded shadow-sm p-5 text-center">
        <p class="text-3xl font-bold text-purple-600">{{ $courses }}</p>
        <p class="text-sm text-gray-500 mt-1">Courses</p>
    </div>
    <div class="bg-white rounded shadow-sm p-5 text-center">
        <p class="text-3xl font-bold text-orange-600">{{ $classes }}</p>
        <p class="text-sm text-gray-500 mt-1">Class Sections</p>
    </div>
</div>
@endsection
