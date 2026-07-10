<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    <style>
        body {
            background-color: #f5f7fb;
        }
        .admin-sidebar {
            width: 260px;
            min-height: 100vh;
            background-color: #0a1e4d;
            color: #ffffff;
        }
        .admin-sidebar .nav-link {
            color: #b7c2e0;
            padding: 0.6rem 1.25rem;
            border-radius: 6px;
            font-size: 0.95rem;
        }
        .admin-sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.08);
            color: #ffffff;
        }
        .admin-sidebar .nav-link.active {
            background-color: #16327a;
            color: #ffffff;
            font-weight: 500;
        }
        .admin-sidebar .brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .admin-sidebar .brand h5 {
            font-weight: 700;
            margin-bottom: 0.15rem;
        }
        .admin-sidebar .brand small {
            color: #8fa0cc;
        }
        .admin-topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e7eaf3;
            padding: 1rem 2rem;
        }
        .admin-main {
            padding: 2rem;
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="admin-sidebar d-flex flex-column">
            <div class="brand">
                <h5 class="mb-0">Cambodia High School</h5>
                <small>Academic Year 2025-2026</small>
            </div>
            <nav class="nav flex-column px-3 py-3 gap-1">
                <a href="{{ route('admin.dashboard') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
                <a href="{{ route('admin.students.index') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Students
                </a>
                <a href="{{ route('admin.teachers.index') }}" class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                    <i class="bi bi-mortarboard-fill"></i> Teachers
                </a>
                <a href="#" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-journal-bookmark-fill"></i> Classes
                </a>
                <a href="#" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-calendar-check-fill"></i> Attendance
                </a>
                <a href="#" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-clipboard-check-fill"></i> Exams
                </a>
                <a href="#" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-megaphone-fill"></i> Announcements
                </a>
                <a href="#" class="nav-link d-flex align-items-center gap-2">
                    <i class="bi bi-bar-chart-fill"></i> Reports
                </a>
            </nav>
        </aside>

        <!-- Main content -->
        <div class="d-flex flex-column flex-grow-1">
            <header class="admin-topbar d-flex justify-content-between align-items-center">
                <div>@yield('header')</div>
                <div class="text-muted small">{{ auth()->user()->name ?? '' }}</div>
            </header>
            <main class="admin-main">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>