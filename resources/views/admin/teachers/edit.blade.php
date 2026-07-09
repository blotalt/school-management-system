@extends('layouts.sms')

@section('content')
<div class="max-w-xl">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Edit Teacher</h2>
        <a href="{{ route('admin.teachers.index') }}" class="text-sm text-gray-500 hover:underline">Back</a>
    </div>

    @if($errors->any())
        <div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded text-sm">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <div class="bg-white rounded shadow-sm p-6">
        <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $teacher->user->name) }}" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $teacher->user->email) }}" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Employee Code</label>
                <input type="text" name="employee_code" value="{{ old('employee_code', $teacher->employee_code) }}" required
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                <input type="text" name="department" value="{{ old('department', $teacher->department) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded text-sm hover:bg-blue-700">
                Update Teacher
            </button>
        </form>
    </div>
</div>
@endsection
