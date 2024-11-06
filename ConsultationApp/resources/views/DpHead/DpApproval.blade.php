@extends('layouts.app')

@section('title', 'Consultation Approvals')

@section('content')
<h2>Consultation DpHead Approvals</h2>

@if($consultations->isEmpty())
    <p>No pending consultations for approval.</p>
@else
    <table class="approval-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Course/Grade Level/Section</th>
                <th>Purpose</th>
                <th>Meeting Mode</th>
                <th>Meeting Preference</th>
                <th>Date / Time</th>
                <th>Action</th>
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
                    <td>
                        <form method="POST" action="{{ route('consultation.accept', $consultation->id) }}" style="display:inline;">
                            @csrf
                            <button type="submit">Approve</button>
                        </form>

                        <button type="button" onclick="document.getElementById('declineModal{{ $consultation->id }}').style.display='block'">Decline</button>
                        
                        <!-- Modal for Decline Reason -->
                        <div id="declineModal{{ $consultation->id }}" style="display:none;">
                            <h3>Decline Reason</h3>
                            <form method="POST" action="{{ route('consultation.decline', $consultation->id) }}">
                                @csrf
                                <textarea name="decline_reason" required placeholder="Provide a reason for declining..."></textarea>
                                <button type="submit">Submit</button>
                                <button type="button" onclick="document.getElementById('declineModal{{ $consultation->id }}').style.display='none'">Cancel</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
