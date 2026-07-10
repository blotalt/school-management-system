<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Enrollments</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
                @endif

                <a href="{{ route('admin.enrollments.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    + Enroll Student
                </a>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Student</th>
                            <th class="py-2">Course</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrollments as $enrollment)
                            <tr class="border-b">
                                <td class="py-2">{{ $enrollment->student->user->name }}</td>
                                <td class="py-2">{{ $enrollment->classSection->course->title }}</td>
                                <td class="py-2">{{ ucfirst($enrollment->status) }}</td>
                                <td class="py-2">
                                    @if ($enrollment->status === 'active')
                                        <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST" class="inline" onsubmit="return confirm('Drop this enrollment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Drop</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-4 text-gray-500">No enrollments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $enrollments->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>