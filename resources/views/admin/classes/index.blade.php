@extends('layouts.sms')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold text-gray-800">Class Sections</h2>
    <a href="{{ route('admin.classes.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Add Class</a>
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
                <th class="px-4 py-3">Capacity</th>
                <th class="px-4 py-3">Enrolled</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($classes as $class)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $class->course->name }}</td>
                <td class="px-4 py-3">{{ $class->teacher->user->name }}</td>
                <td class="px-4 py-3">{{ $class->room }}</td>
                <td class="px-4 py-3">{{ $class->day }}</td>
                <td class="px-4 py-3">{{ $class->start_time }} - {{ $class->end_time }}</td>
                <td class="px-4 py-3">{{ $class->capacity }}</td>
                <td class="px-4 py-3">{{ $class->enrolledCount() }}</td>
                <td class="px-4 py-3 flex gap-3">
                    <a href="{{ route('admin.classes.edit', $class) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.classes.destroy', $class) }}"
                          onsubmit="return confirm('Delete this class?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-4 py-6 text-center text-gray-400">No class sections found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $classes->links() }}</div>
@endsection
