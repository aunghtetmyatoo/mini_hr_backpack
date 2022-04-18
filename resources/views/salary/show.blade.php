@extends(backpack_view('blank'))

@section('content')
<h2>
    <span class="text-capitalize">Salaries</span>
    <small>Add salary.</small>

    <small><a href="{{ route('salary.create') }}" class="d-print-none font-sm"><i class="la la-angle-double-left"></i> Back to all  <span>salaries</span></a></small>
</h2>

<a href="{{ route('salary.slip') }}" class="btn btn-success mb-3 print-window">Print</a>

@foreach ($employees as $employee)

    <table class="table table-bordered table-active">
        <tbody class="col-md-6">
            @php
                $count = 0;
            @endphp
    
            <tr>
                <td class="col-md-3">Employee Name</td>
                <td class="col-md-3">
                    <input type="hidden" name="employee_id[]" value="{{ $employee['id'] }}">
                    {{ $employee['name'] }}
                </td>
            </tr>
            <tr>
                <td>Per Working Day</td>
                <td>{{ number_format((float)$employee['salary_rate']/22, 2, '.', '') }}</td>
            </tr>
            <tr>
                <td>Leave Days</td>
                <td>
                    <div @foreach($attendances as $attendance) 
                    @if($employee['id'] == $attendance['employee_id']) 
                        @if (($attendance['morning'] == 0 && $attendance['evening'] == 0))
                            {{ $count+=1 }}
                        @elseif ($attendance['mornsing'] == 0 || $attendance['evening'] == 0)
                            {{ $count+=0.5 }}
                        @endif
                    @endif 
                @endforeach>{{ $count }}</div>
                </td>
            </tr>
            <tr>
                <td>Leave Amounts</td>
                <td>{{ number_format((float)$employee['salary_rate']/22*$count, 2, '.', '') }}</td>
            </tr>
            <tr>
                <td>Net Salary</td>
                <td>{{ number_format((float)$employee['salary_rate']-$employee['salary_rate']/22*$count, 2, '.', '') }}</td>
            </tr>
        </tbody>
      </table><br>

@endforeach

<script>
    $(document).ready(function(){
        $('.print-window').click(function() {
            window.print();
        });
    });
</script>

  
@endsection


 
