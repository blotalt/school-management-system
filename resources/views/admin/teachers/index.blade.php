@extends('layouts.sms')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold text-gray-800">Teachers</h2>
    <a href="{{ route('admin.teachers.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Add Teacher</a>
</div>

<div class="bg-white rounded shadow-sm overflow-hidden">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 text-left">
            <tr>
                <th class="px-4 py-3">Employee Code</th>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Department</th>
                <th class="px-4 py-3">Phone</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($teachers as $teacher)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">{{ $teacher->employee_code }}</td>
                <td class="px-4 py-3">{{ $teacher->user->name }}</td>
                <td class="px-4 py-3">{{ $teacher->user->email }}</td>
                <td class="px-4 py-3">{{ $teacher->department ?? '-' }}</td>
                <td class="px-4 py-3">{{ $teacher->phone ?? '-' }}</td>
                <td class="px-4 py-3 flex gap-3">
                    <a href="{{ route('admin.teachers.edit', $teacher) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.teachers.destroy', $teacher) }}"
                          onsubmit="return confirm('Delete this teacher?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-400">No teachers found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $teachers->links() }}</div>
@endsection
