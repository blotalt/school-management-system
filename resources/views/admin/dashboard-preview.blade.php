@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')

<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold mb-1">Institutional Dashboard</h3>
        <div class="text-muted small">Academic Session: 2025-2026 • Senior Secondary Department</div>
    </div>

    <div class="btn-group" role="group">
        <button type="button" class="btn btn-primary btn-sm">Overall View</button>
        <button type="button" class="btn btn-outline-secondary btn-sm">Grade 10</button>
        <button type="button" class="btn btn-outline-secondary btn-sm">Grade 11</button>
        <button type="button" class="btn btn-outline-secondary btn-sm">Grade 12</button>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex p-2 mb-3">
                    <i class="bi bi-people-fill text-primary fs-5"></i>
                </div>
                <div class="fs-3 fw-bold">{{ $totalStudents ?? 1240 }}</div>
                <div class="text-muted small">Total Students</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="bg-info bg-opacity-10 rounded-3 d-inline-flex p-2 mb-3">
                    <i class="bi bi-mortarboard-fill text-info fs-5"></i>
                </div>
                <div class="fs-3 fw-bold">{{ $totalTeachers ?? 84 }}</div>
                <div class="text-muted small">Total Teachers</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="bg-success bg-opacity-10 rounded-3 d-inline-flex p-2 mb-3">
                    <i class="bi bi-check-circle-fill text-success fs-5"></i>
                </div>
                <div class="fs-3 fw-bold">{{ $attendanceRate ?? 96.5 }}%</div>
                <div class="text-muted small">Attendance Rate</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="bg-dark bg-opacity-10 rounded-3 d-inline-flex p-2 mb-3">
                    <i class="bi bi-building-fill text-dark fs-5"></i>
                </div>
                <div class="fs-3 fw-bold">{{ $totalClasses ?? 42 }}</div>
                <div class="text-muted small text-uppercase">Active Classes</div>
            </div>
        </div>
    </div>
</div>

<!-- Classes Overview -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold">Classes Overview</span>
        <a href="#" class="small text-decoration-none">View All Classes</a>
    </div>
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3">Class Name</th>
                    <th>Track</th>
                    <th>Students</th>
                    <th>Attendance</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $classesDemo = [
                        ['name' => 'Grade 12 - A', 'track' => 'Science', 'students' => 42, 'attendance' => 98],
                        ['name' => 'Grade 12 - B', 'track' => 'Geography', 'students' => 38, 'attendance' => 95],
                        ['name' => 'Grade 11 - A', 'track' => 'Science', 'students' => 45, 'attendance' => 97],
                        ['name' => 'Grade 11 - B', 'track' => 'Geography', 'students' => 40, 'attendance' => 94],
                    ];
                @endphp
                @foreach($classesDemo as $c)
                <tr>
                    <td class="ps-3 fw-semibold">{{ $c['name'] }}</td>
                    <td>
                        <span class="badge {{ $c['track'] === 'Science' ? 'bg-primary-subtle text-primary' : 'bg-warning-subtle text-warning-emphasis' }} text-uppercase">
                            {{ $c['track'] }}
                        </span>
                    </td>
                    <td>{{ $c['students'] }}</td>
                    <td style="width: 220px;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress flex-grow-1" style="height: 6px;">
                                <div class="progress-bar bg-dark" style="width: {{ $c['attendance'] }}%"></div>
                            </div>
                            <span class="small fw-semibold">{{ $c['attendance'] }}%</span>
                        </div>
                    </td>
                    <td class="text-end pe-3">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">View</a></li>
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Actions -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-semibold">Quick Actions</div>
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <a href="{{ route('admin.students.create') }}" class="btn btn-outline-secondary w-100 py-3 d-flex flex-column align-items-center gap-2">
                    <i class="bi bi-person-plus fs-4"></i>
                    <span>Add Student</span>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#" class="btn btn-outline-secondary w-100 py-3 d-flex flex-column align-items-center gap-2">
                    <i class="bi bi-calendar3 fs-4"></i>
                    <span>Timetable</span>
                </a>
            </div>
            <div class="col-md-4">
                <a href="#" class="btn btn-outline-secondary w-100 py-3 d-flex flex-column align-items-center gap-2">
                    <i class="bi bi-megaphone fs-4"></i>
                    <span>Announcements</span>
                </a>
            </div>
        </div>

        <div class="bg-light rounded-3 p-3">
            <div class="fw-semibold small mb-1">Next Staff Meeting</div>
            <div class="text-muted small">Today at 3:30 PM • Conference Room A</div>
        </div>
    </div>
</div>

@endsection