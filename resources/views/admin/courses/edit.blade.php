@extends('layouts.sms')

@section('content')
<div class="max-w-xl">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Edit Course</h2>
        <a href="{{ route('admin.courses.index') }}" class="text-sm text-gray-500 hover:underline">Back</a>
    </div>

    @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded text-sm">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <div class="bg-white rounded shadow-sm p-6">
        <form method="POST" action="{{ route('admin.courses.update', $course) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Course Name</label>
                <input type="text" name="name" value="{{ old('name', $course->name) }}" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Course Code</label>
                <input type="text" name="code" value="{{ old('code', $course->code) }}" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Credits</label>
                <input type="number" name="credits" value="{{ old('credits', $course->credits) }}" min="1" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded px-3 py-2 text-sm">{{ old('description', $course->description) }}</textarea>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded text-sm hover:bg-blue-700">
                Update Course
            </button>
        </form>
    </div>
</div>
@endsection
