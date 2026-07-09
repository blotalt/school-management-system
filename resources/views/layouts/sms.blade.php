<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>School Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-white shadow-sm px-6 py-3 flex justify-between items-center">
    <span class="font-semibold text-gray-800">School Management System</span>
    @auth
    <div class="flex items-center gap-4">
        <span class="text-sm text-gray-500">{{ auth()->user()->name }} &middot; {{ ucfirst(auth()->user()->role) }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-sm text-red-500 hover:underline">Logout</button>
        </form>
    </div>
    @endauth
</nav>

<div class="flex">
    @auth
    <aside class="w-52 bg-white shadow-sm min-h-screen p-4 text-sm">
        @if(auth()->user()->isAdmin())
            <p class="text-xs font-semibold text-gray-400 uppercase mb-2 px-3">Admin</p>
            <ul class="space-y-1">
                <li><a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100 text-gray-700">Dashboard</a></li>
                <li><a href="{{ route('admin.students.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 text-gray-700">Students</a></li>
                <li><a href="{{ route('admin.teachers.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 text-gray-700">Teachers</a></li>
                <li><a href="{{ route('admin.courses.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100 text-gray-700">Courses</a></li>
            </ul>
        @elseif(auth()->user()->isTeacher())
            <p class="text-xs font-semibold text-gray-400 uppercase mb-2 px-3">Teacher</p>
            <ul class="space-y-1">
                <li><a href="{{ route('teacher.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100 text-gray-700">Dashboard</a></li>
            </ul>
        @elseif(auth()->user()->isStudent())
            <p class="text-xs font-semibold text-gray-400 uppercase mb-2 px-3">Student</p>
            <ul class="space-y-1">
                <li><a href="{{ route('student.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100 text-gray-700">Dashboard</a></li>
            </ul>
        @endif
    </aside>
    @endauth

    <main class="flex-1 p-6">
        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded text-sm">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

</body>
</html>
