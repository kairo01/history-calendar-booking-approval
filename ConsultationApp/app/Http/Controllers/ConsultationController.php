<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\BusySlot;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function showCollegeConsultation()
    {
        return view('student.consultation.CollegeConsult');
    }

    public function showHSchoolConsultation()
    {
        return view('student.consultation.HSchoolConsult');
    }

    public function submitConsultation(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'course' => 'required|string|max:255',
        'purpose' => 'required|string',
        'consultant' => 'required|string',
        'meeting_mode' => 'required|string',
        'online_platform' => 'nullable|string',
        'schedule_date' => 'required|date',
        'schedule_time' => 'required',
    ]);

    $validated['schedule'] = $validated['schedule_date'] . ' ' . $validated['schedule_time'];
    unset($validated['schedule_date'], $validated['schedule_time']);
    $validated['student_id'] = auth()->id();

    $consultation = Consultation::create($validated);

    // Return JSON response for the success modal
    if ($validated['consultant'] === 'department_head') {
        return response()->json([
            'success' => true,
            'message' => 'Consultation request sent to Department Head for approval.'
        ]);
    } else {
        return response()->json([
            'success' => true,
            'message' => 'Consultation request sent to Admin Consultant for approval.'
        ]);
    }
}


    
public function dpHeadApproval()
{
    // Fetch only pending consultations for the department head
    $consultations = Consultation::where('status', 'pending')
                                 ->where('consultant', 'department_head')
                                 ->get();

    return view('DpHead.DpApproval', compact('consultations'));
}

public function adminCtationApproval()
{
    // Fetch only pending consultations for the admin consultant
    $consultations = Consultation::where('status', 'pending')
                                 ->where('consultant', 'admin_consultant')
                                 ->get();

    return view('AdminCtation.CtApproval', compact('consultations'));
}



public function adminCalendar()
{
    $consultations = Consultation::where('status', 'approved')->get();
    $busySlots = BusySlot::all(); // Get all busy slots

    return view('AdminCtation.CtCalendar', compact('consultations', 'busySlots'));
}

public function dpCalendar()
{
    $consultations = Consultation::where('status', 'approved')->get();
    $busySlots = BusySlot::all(); // Get all busy slots

    return view('DpHead.DpCalendar', compact('consultations', 'busySlots'));
}

public function studentCalendar()
{
    $consultations = Consultation::where('status', 'approved')->where('student_id', auth()->id())->get();
    $busySlots = BusySlot::all(); // Get all busy slots

    return view('student.StudentCalendar', compact('consultations', 'busySlots'));
}

public function storeBusySlot(Request $request)
{
    $request->validate([
        'consultation_id' => 'required|exists:consultations,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date',
        'busy_times' => 'required|array',
    ]);

    BusySlot::create([
        'consultation_id' => $request->input('consultation_id'),
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'date' => $request->input('date'),
        'busy_times' => json_encode($request->input('busy_times')),
    ]);

    return response()->json(['success' => true, 'message' => 'Busy slot created successfully!']);
}

    

    // New History Methods
    public function adminHistory()
{
    // Include declined consultations
    $consultations = Consultation::where('consultant', 'admin_consultant')
                                  ->whereIn('status', ['approved', 'declined'])
                                  ->get();

    return view('AdminCtation.Cthistory', compact('consultations'));
}

public function dpHistory()
{
    // Include declined consultations
    $consultations = Consultation::where('consultant', 'department_head')
                                  ->whereIn('status', ['approved', 'declined'])
                                  ->get();

    return view('DpHead.DpHistory', compact('consultations'));
}

public function studentHistory()
{
    // Include declined consultations for the student
    $consultations = Consultation::where('student_id', auth()->id())
                                  ->whereIn('status', ['approved', 'declined'])
                                  ->get();

    return view('student.StudentHistory', compact('consultations'));
}


public function accept($id)
{
    // Find the consultation by ID
    $consultation = Consultation::findOrFail($id);
    
    // Change the status to 'approved'
    $consultation->status = 'approved';
    $consultation->save();

    // Redirect to the appropriate approval list based on the consultant type
    if ($consultation->consultant === 'department_head') {
        // Redirect to the Department Head calendar view
        return redirect()->route('dp.calendar') // Redirect to the dp.calendar route
                         ->with('success', 'Consultation has been approved.');
    } elseif ($consultation->consultant === 'admin_consultant') {
        // Redirect to the Admin Consultant calendar view
        return redirect()->route('admin.calendar') // Redirect to the admin.calendar route
                         ->with('success', 'Consultation has been approved.');
    }

    // Fallback if the consultant type is unexpected
    return redirect()->back()->with('error', 'Consultant type not recognized.');
}


public function decline(Request $request, $id)
{
    $request->validate([
        'decline_reason' => 'required|string|max:255',
    ]);

    $consultation = Consultation::findOrFail($id);
    $consultation->status = 'declined'; // Set the status to declined
    $consultation->decline_reason = $request->input('decline_reason'); // Save the decline reason
    $consultation->save();

    if ($consultation->consultant === 'department_head') {
        return redirect()->route('dpHead.approval')
                         ->with('success', 'Consultation has been declined.');
    } elseif ($consultation->consultant === 'admin_consultant') {
        return redirect()->route('adminCtation.approval')
                         ->with('success', 'Consultation has been declined.');
    }

    return redirect()->back()->with('error', 'Consultant type not recognized.');
}

}
