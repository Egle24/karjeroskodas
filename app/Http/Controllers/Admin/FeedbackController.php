<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(){

        $feedbacks = Feedback::all();
        $camps = Camp::all();
        $users = User::all();
        return view('admin.feedbacks.index', compact('feedbacks','camps', 'users'));
    }

    public function update(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->status =  $request->input('status');
        $feedback->save();

        return redirect()->back()->with('success', 'Atsiliepimo statusas sėkmingai pakeistas');
    }

    public function destroy(Request $request, $id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('admin.feedbacks.index')->with('success', 'Atsiliepimas sėkmingai pašalintas.');
    }
}
