@extends(backpack_view('blank'))

@section('content')
<h2>
    <span class="text-capitalize">Salaries</span>
    <small>Add salary.</small>

    <small><a href="{{ route('salary.index') }}" class="d-print-none font-sm"><i class="la la-angle-double-left"></i> Back to all  <span>positions</span></a></small>
</h2>
<form method="POST" action="{{ route('salary.save') }}">
    @csrf
    <table class="table">
        <thead>
          <tr>
            <th scope="col">Employee Name</th>
            <th scope="col">Per Working Day</th>
            <th scope="col">Leave Days</th>
            <th scope="col">Leave Amounts(or)Late</th>
            <th scope="col">Net Salary</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            @php
                $count = 0;
            @endphp
    
                
                    <tr>
                        <td>
                            <input type="hidden" name="employee_id[]" value="{{ $employee['id'] }}">
                                {{ $employee['name'] }}
                        </td>
                        <td>
                            <div>{{ number_format((float)$employee['salary_rate']/22, 2, '.', '') }}</div>
                        </td>
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
    
                            <input type="hidden" name="leave_day[]" value="{{ $count }}">
                        </td>
                        
                        <td>
                            <div>
                                {{ number_format((float)$employee['salary_rate']/22*$count, 2, '.', '') }}
                            </div>
                            
                            <input type="hidden" name="leave_amount[]" value="{{ number_format((float)$employee['salary_rate']/22*$count, 2, '.', '') }}">
                        </td>
                        <td>
                            <div>{{ number_format((float)$employee['salary_rate']-$employee['salary_rate']/22*$count, 2, '.', '') }}</div>
    
                            <input type="hidden" type="text" name="salary[]" value="{{ number_format((float)$employee['salary_rate']-$employee['salary_rate']/22*$count, 2, '.', '') }}">
                        </td>
                        
                    </tr>
            @endforeach
        </tbody>
      </table>
      <button type="submit" class="btn btn-success">
        <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
        <span data-value="save_and_back">Save and back</span>
    </button>

    <a href="{{ route('salary.slip') }}" class="btn btn-success ml-3">Pay Slip</a>
</form>

{{-- <button type="submit" class="btn btn-success">
    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
    <span data-value="save_and_back">Save and back</span>
</button>

<a href="{{ route('salary.show', $employee['id']) }}"> --}}

  
@endsection


 
