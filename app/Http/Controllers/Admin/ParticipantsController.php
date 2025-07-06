<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\UserCamps;
use Illuminate\Http\Request;

class ParticipantsController extends Controller
{
    public function index($id)
    {
        $camp = Camp::find($id);
        $participants = $camp->registrations;
        return view('admin.camps.participants', compact('participants', 'camp'));
    }

    public function update(Request $request, $campId, $participantId)
    {
        $camp = Camp::find($campId);
        $participants = UserCamps::find($participantId);
        $participants->paid =  $request->input('paid');
        $participants->save();

        return redirect()->route('admin.camps.participants.show', $camp->id)->with('success', 'Sėkmingai pakeitėte statusą');
    }

    public function delete($campId)
    {
        $camp = Camp::findOrFail($campId);
        $participants = $camp->registrations;

        return view('admin.camps.participants.delete', compact('camp', 'participants'));
    }

    public function destroy(Request $request, $campId)
    {
        $request->validate([
            'selected_participants' => 'required|array',
            'selected_participants.*' => 'exists:user_camps,id',
        ]);

        $selectedParticipants = $request->input('selected_participants');

        foreach ($selectedParticipants as $participantId) {
            $participant = UserCamps::where('id', $participantId)->where('camp_id', $campId)->firstOrFail();
            $participant->delete();
        }

        return redirect()->route('admin.camps.participants.show', $campId)
            ->with('success', 'Pasirinkti dalyviai sėkmingai pašalinti.');
    }
}
