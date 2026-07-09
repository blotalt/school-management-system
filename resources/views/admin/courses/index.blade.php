@extends('layouts.sms')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold text-gray-800">Courses</h2>
    <a href="{{ route('admin.courses.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Add Course</a>
</div>

<div class="bg-white rounded shadow-sm overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 text-left">
            <tr>
                <th class="px-4 py-3">Code</th>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Credits</th>
                <th class="px-4 py-3">Description</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($courses as $course)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $course->code }}</td>
                <td class="px-4 py-3">{{ $course->name }}</td>
                <td class="px-4 py-3">{{ $course->credits }}</td>
                <td class="px-4 py-3 max-w-xs truncate">{{ $course->description ?? '-' }}</td>
                <td class="px-4 py-3 flex gap-3">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                          onsubmit="return confirm('Delete this course?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-6 text-center text-gray-400">No courses found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $courses->links() }}</div>
@endsection
