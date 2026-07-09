@extends('layouts.sms')

@section('content')
<div class="max-w-xl">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Edit Class Section</h2>
        <a href="{{ route('admin.classes.index') }}" class="text-sm text-gray-500 hover:underline">Back</a>
    </div>

    @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded text-sm">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <div class="bg-white rounded shadow-sm p-6">
        <form method="POST" action="{{ route('admin.classes.update', $class) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                <select name="course_id" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id', $class->course_id) == $course->id ? 'selected' : '' }}>
                            {{ $course->code }} - {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teacher</label>
                <select name="teacher_id" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id', $class->teacher_id) == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->user->name }} ({{ $teacher->department ?? $teacher->employee_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Room</label>
                <input type="text" name="room" value="{{ old('room', $class->room) }}" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Day</label>
                <select name="day" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                        <option value="{{ $day }}" {{ old('day', $class->day) == $day ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                    <input type="time" name="start_time" value="{{ old('start_time', $class->start_time) }}" required
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                    <input type="time" name="end_time" value="{{ old('end_time', $class->end_time) }}" required
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Capacity</label>
                <input type="number" name="capacity" value="{{ old('capacity', $class->capacity) }}" min="1" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded text-sm hover:bg-blue-700">
                Update Class Section
            </button>
        </form>
    </div>
</div>
@endsection
