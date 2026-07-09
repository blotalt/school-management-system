@extends('layouts.sms')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold text-gray-800">Students</h2>
    <a href="{{ route('admin.students.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Add Student</a>
</div>

<div class="bg-white rounded shadow-sm overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 text-left">
            <tr>
                <th class="px-4 py-3">Code</th>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Phone</th>
                <th class="px-4 py-3">Date of Birth</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($students as $student)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $student->student_code }}</td>
                <td class="px-4 py-3">{{ $student->user->name }}</td>
                <td class="px-4 py-3">{{ $student->user->email }}</td>
                <td class="px-4 py-3">{{ $student->phone ?? '-' }}</td>
                <td class="px-4 py-3">{{ $student->date_of_birth ?? '-' }}</td>
                <td class="px-4 py-3 flex gap-3">
                    <a href="{{ route('admin.students.edit', $student) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.students.destroy', $student) }}"
                          onsubmit="return confirm('Delete this student?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-400">No students found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $students->links() }}</div>
@endsection
