@extends(backpack_view('blank'))


@php
$widgets['after_content'][] = [
    'type' => 'chart',
    'controller' => \App\Http\Controllers\Admin\Charts\NumberOfEmployeesChartController::class,

    // OPTIONALS

    'class' => 'card mb-4',
    'wrapper' => ['class' => 'col-md-6 float-left'],
    'content' => [
        'body' => 'Number of Employees',
    ],
];

$widgets['after_content'][] = [
    'type' => 'chart',
    'controller' => \App\Http\Controllers\Admin\Charts\EmployeeByPositionChartController::class,

    // OPTIONALS

    'class' => 'card mb-4',
    'wrapper' => ['class' => 'col-md-6 float-left'],
    'content' => [
        'body' => 'Employees By Positions',
    ],
];

$widgets['after_content'][] = [
    'type' => 'progress',
    'class' => 'card text-white bg-warning mb-4',
    'value' => $leave_employees_by_day,
    'description' => 'Leave Employees Day By Day',
    'progress' => 20, // integer
    'progressClass' => 'progress-bar bg-primary',
    'hint' => '8544 more until next milestone.',
    'wrapper' => ['class' => 'col-md-6 float-left'],
];

$widgets['after_content'][] = [
    'type' => 'progress',
    'class' => 'card text-white bg-danger mb-4',
    'value' => $leave_employees->count(),
    'description' => 'Leave Employees greater than 5 days Month By Month',
    'progress' => 20, // integer
    'progressClass' => 'progress-bar bg-primary',
    'hint' => '8544 more until next milestone.',
    'wrapper' => ['class' => 'col-md-6 float-left'],
];
@endphp

@section('content')
    <nav aria-label="breadcrumb" class="d-none d-lg-block">
        <ol class="breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="{{ route('dashboard') }}">Admin</a></li>
            <li class="breadcrumb-item text-capitalize">Dashboard</li>
        </ol>
    </nav>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Employees List whose leave days are greater than 5 days</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center"><i class="icon-people"></i></th>
                            <th>Employee Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Position</th>
                            <th>Leave Days</th>
                        </tr>
                    </thead>
                    @foreach ($leave_employees as $leave_employee)
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <div class="avatar"><img class="img-avatar"
                                            src="{{ asset($leave_employee->employee->photo) }}" alt=""></div>
                                </td>
                                <td>
                                    {{ $leave_employee->employee->name }}
                                </td>
                                <td>
                                    {{ $leave_employee->employee->email }}
                                </td>
                                <td>
                                    {{ $leave_employee->employee->phone_number }}
                                </td>
                                <td>
                                    {{ $leave_employee->employee->position->name }}
                                </td>
                                <td>
                                    {{ $leave_employee->leave_day }}
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
