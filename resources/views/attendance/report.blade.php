@extends(backpack_view('blank'))

@section('content')
    <nav aria-label="breadcrumb" class="d-none d-lg-block">
        <ol class="breadcrumb bg-transparent p-0 justify-content-end">
            <li class="breadcrumb-item text-capitalize"><a href="{{ route('dashboard') }}">Admin</a></li>
            <li class="breadcrumb-item text-capitalize"><a href="{{ route('attendance.index') }}">attendances</a></li>
            <li class="breadcrumb-item text-capitalize active" aria-current="page">List</li>
        </ol>
    </nav>

    <h2>
        <span class="text-capitalize">attendances</span>
    </h2>

    <div class="row justify-content-between">
        <div class="col-md-3">
            <select id="employee_id" class="form-control" placeholder="Select City" multiple="multiple">
                @foreach ($employees as $employee)
                    <option value="{{ $employee['id'] }}" class="name_search">{{ $employee['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <input type="text" name="search" id="date_search" class="form-control rounded-pill date" placeholder="Date..."
                value="{{ $date }}">
        </div>
        <div class="col-md-3">
            <input type="submit" value="Search" class="btn btn-primary" id="search_btn">
        </div>
    </div>

    <div class="report_table">

    </div>

    

    <script>
        $('#date_search').daterangepicker({
            singleDatePicker: false,
            autoApply: true,
            locale: {
                format: 'YYYY-MM-DD'
            },
        });
        $('#date_search').on('apply.daterangepicker', function(ev, picker) {
            var search = $('#date_search').val();
            var value = $('#date_search').val().split(' - ');
            var from = value.shift();
            var to = value.join();

            history.pushState(null, "", `?search=${search}&from=${from}&to=${to}`);
            // window.location.reload();
        });
        $('#search_btn').on('click', function() {
            var employee_id = $('#employee_id').val();
            var search = $('#date_search').val();
            var value = $('#date_search').val().split(' - ');
            var from = value.shift();
            var to = value.join();

            // alert(employee_id);

            $.ajax({
                method: "POST",
                url: "/admin/attendance/report",
                data: {
                    employee_id: employee_id,
                    from: from,
                    to: to,
                },
                success: function(data) {
                    $('.report_table').html(data);
                }
            });
        });

        $('#employee_id').select2({
            placeholder: 'Search Name'
        });
    </script>
@endsection
