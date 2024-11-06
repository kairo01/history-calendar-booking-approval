@extends('layouts.app')

@section('title', 'Admin Consultation History')

@section('content')
    <h2>Admin Consultant Consultation History</h2>

    @if($consultations->isEmpty())
        <p>No consultations have been recorded in the Admin Consultant’s history.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Course/Grade Level/Section</th>
                    <th>Purpose</th>
                    <th>Meeting Mode</th>
                    <th>Online Platform</th>
                    <th>Schedule</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach($consultations as $consultation)
    <tr>
        <td>{{ $consultation->name }}</td>
        <td>{{ $consultation->course }}</td>
        <td>{{ $consultation->purpose }}</td>
        <td>{{ $consultation->meeting_mode }}</td>
        <td>{{ $consultation->online_platform ?? 'N/A' }}</td>
        <td>{{ $consultation->schedule->format('M d, Y - h:i A') }}</td>
        <td>{{ ucfirst($consultation->status) }}</td> <!-- Show the status here -->
        <td>{{ $consultation->decline_reason ?? 'N/A' }}</td> <!-- Optionally show decline reason -->
    </tr>
@endforeach

            </tbody>
        </table>
    @endif
@endsection