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
    <div class="col-sm-4">
        <div class="d-print-none with-border">
            <a href="{{ route('attendance.create') }}" class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i class="la la-plus"></i> Add position</span></a>
        </div>
    </div>
    <div class="col-sm-3">
        <input type="text" name="search" id="date_search" class="form-control rounded-pill date" placeholder="Date..." value="{{ $date }}">
    </div>
</div>

<table class="table mt-4">
    <thead>
      <tr>
        <th scope="col">Employee Name</th>
        <th scope="col">Morning</th>
        <th scope="col">Evening</th>
        <th scope="col">Date</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($attendances as $attendance)
            <tr>
                <td>
                    {{ $attendance->employee->name }}
                </td>
                <td>
                    @if ($attendance['morning'] == 1)
                        <i class="la la-check-circle la-lg"></i>
                    @else
                        <i class="la la-circle la-lg"></i>
                    @endif
                </td>
                <td>
                    @if ($attendance['evening'] == 1)
                        <i class="la la-check-circle la-lg"></i>
                    @else
                        <i class="la la-circle la-lg"></i>
                    @endif
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($attendance['created_at'])->format('d/m/Y')}}
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>

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
  </script>

  
@endsection
 
