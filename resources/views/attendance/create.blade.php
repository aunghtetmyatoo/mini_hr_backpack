@extends(backpack_view('blank'))

@section('content')
    <h2>
        <span class="text-capitalize">Attendances</span>
        <small>Add attendance.</small>

        <small><a href="{{ route('attendance.index') }}" class="d-print-none font-sm"><i
                    class="la la-angle-double-left"></i> Back to all <span>positions</span></a></small>
    </h2>

    <div class="row mb-4">
        <div class="col-sm-2">
            <input type="text" name="search" id="date_search" class="form-control rounded-pill date" placeholder="Date..."
                value="{{ $date }}">
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Employee Name</th>
                <th scope="col">Morning</th>
                <th scope="col">Evening</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>
                        {{ $employee->name }}
                    </td>
                    <td>
                        <div class="form-check">
                            <input type="checkbox" name="morning" class="morning_checkbox"
                                data-employee-id={{ $employee->id }}
                                @foreach ($attendances as $attendance) {{ $attendance['morning'] == 1 && $employee->id == $attendance['employee_id'] ? ' checked' : '' }} @endforeach>
                        </div>
                    </td>
                    <td>
                        <div class="form-check">
                            <input type="checkbox" name="evening" class="evening_checkbox"
                                data-employee-id={{ $employee->id }}
                                @foreach ($attendances as $attendance) {{ $attendance['evening'] == 1 && $employee->id == $attendance['employee_id'] ? ' checked' : '' }} @endforeach>
                        </div>
                    </td>
                    <td>
                        <input type="hidden" class="date" value="{{ $date }}">
                        {{ $date }}
                    </td>
                </tr>
                <script>
                    $('#date_search').daterangepicker({
                        singleDatePicker: true,
                        autoApply: true,
                        locale: {
                            format: 'YYYY-MM-DD'
                        }
                    });
                    $('#date_search').on('apply.daterangepicker', function(ev, picker) {
                        var search = $('#date_search').val();

                        history.pushState(null, "", `?search=${search}`);
                        window.location.reload();
                    });

                    $(document).ready(function() {
                        let token = document.head.querySelector('meta[name="csrf-token"]');
                        if (token) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF_TOKEN': token.content,

                                }
                            });
                        }
                        $('.morning_checkbox').on('change', function() {
                            var employee_id = $(this).data('employee-id');
                            var date = $('.date').val();
                            var morning_checkbox = $(this).prop("checked");
                            $.ajax({
                                method: "POST",
                                url: "/admin/attendance/morning",
                                data: {
                                    employee_id: employee_id,
                                    morning_checkbox: morning_checkbox,
                                    date: date,
                                },
                            }).done(function(response) {
                                if (response.result == 1) {

                                }
                            });
                        });

                        $('.evening_checkbox').on('change', function() {
                            var employee_id = $(this).data('employee-id');
                            var date = $('.date').val();
                            var evening_checkbox = $(this).prop("checked");
                            $.ajax({
                                method: "POST",
                                url: "/admin/attendance/evening",
                                data: {
                                    employee_id: employee_id,
                                    evening_checkbox: evening_checkbox,
                                    date: date,
                                },
                            }).done(function(response) {
                                if (response.result == 1) {

                                }
                            });
                        });


                    });
                </script>
            @endforeach
        </tbody>
    </table>
@endsection
