<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Enrollments</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="font-semibold mb-4">Currently Enrolled</h3>
                @forelse ($myEnrollments as $enrollment)
                    <div class="flex justify-between items-center py-2 border-b">
                        <span>{{ $enrollment->classSection->course->title }} — {{ $enrollment->classSection->day_of_week }} {{ $enrollment->classSection->start_time }}</span>
                        <form action="{{ route('student.enrollments.destroy', $enrollment) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Drop</button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500">Not enrolled in anything yet.</p>
                @endforelse
            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="font-semibold mb-4">Available Classes</h3>
                @foreach ($availableClasses as $class)
                    <div class="flex justify-between items-center py-2 border-b">
                        <span>{{ $class->course->title }} — {{ $class->day_of_week }} {{ $class->start_time }}–{{ $class->end_time }} ({{ $class->activeEnrollmentCount() }}/{{ $class->capacity }})</span>
                        <form action="{{ route('student.enrollments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="class_id" value="{{ $class->id }}">
                            <button class="text-indigo-600 hover:underline">Enroll</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>