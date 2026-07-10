<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Students</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                @endif

                <a href="{{ route('admin.students.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    + Add Student
                </a>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Student No</th>
                            <th class="py-2">Name</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Enrolled</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            <tr class="border-b">
                                <td class="py-2">{{ $student->student_no }}</td>
                                <td class="py-2">{{ $student->user->name }}</td>
                                <td class="py-2">{{ $student->user->email }}</td>
                                <td class="py-2">{{ $student->enrollment_date?->format('Y-m-d') ?? '—' }}</td>
                                <td class="py-2 space-x-2">
                                    <a href="{{ route('admin.students.edit', $student) }}" class="text-indigo-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Delete this student?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-4 text-gray-500">No students yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $students->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>