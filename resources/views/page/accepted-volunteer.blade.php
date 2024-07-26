@extends('layouts.main')
@section('content')
    <div class="mt-5 border p-2 rounded-1 bg-light">
        {{-- @php
        dd($volunteerList);
        @endphp --}}
        <table id="example" class="hover" style="width:100%">
            
              
            <thead>
                <tr>
                    <th>Nama Volunteer</th>
                    <th>Email</th>
                    <th>No.HP</th>
                    <th>Experience</th>
                    <th>Status</th>
                    <th>Reward</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($volunteerList as $item)
                    @if ($item->status == 'accepted')
                        <tr>
                            <td>{{ $item->account['name'] }}</td>
                            <td>{{ $item->account['email'] }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->experience }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->reward }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>
    <script>
        new DataTable('#example');
    </script>
@endpush

@push('css')
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
@endpush
