<form action="{{ route('attendance.export') }}" method="post">
    @csrf
    <input type="submit" value="Export" class="btn btn-primary mt-4">
    <div style="overflow-y: scroll; height:400px;">
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
                            <input type="hidden" name="items[{{ $attendance->id }}][Employee Name]"
                                value="{{ $attendance->employee->name }}">
                        </td>
                        <td>
                            {{-- <input type="checkbox" name="items[{{ $attendance->id }}][morning]" style="opacity:0; position:absolute; left:9999px;"> --}}
                            @if ($attendance['morning'] == 1)
                                <i class="la la-check-circle la-lg"></i>
                                <input type="checkbox" name="items[{{ $attendance->id }}][Morning]" value="Yes"
                                    checked="checked" style="opacity:0; position:absolute; left:9999px;">
                            @elseif ($attendance['morning'] == 0)
                                <i class="la la-circle la-lg"></i>
                                <input type="checkbox" name="items[{{ $attendance->id }}][Morning]" value="No"
                                    checked="checked" style="opacity:0; position:absolute; left:9999px;">
                            @endif
                        </td>
                        <td>
                            @if ($attendance['evening'] == 1)
                                <i class="la la-check-circle la-lg"></i>
                                <input type="checkbox" name="items[{{ $attendance->id }}][Evening]" value="Yes"
                                    checked="checked" style="opacity:0; position:absolute; left:9999px;">
                            @elseif ($attendance['evening'] == 0)
                                <i class="la la-circle la-lg"></i>
                                <input type="checkbox" name="items[{{ $attendance->id }}][Evening]" value="No"
                                    checked="checked" style="opacity:0; position:absolute; left:9999px;">
                            @endif
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($attendance['created_at'])->format('d/m/Y') }}
                            <input type="hidden" name="items[{{ $attendance->id }}][Date]" value="{{ \Carbon\Carbon::parse($attendance['created_at'])->format('d/m/Y') }}
                                ">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>
