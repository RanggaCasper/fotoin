<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Calendar;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function view_calendar(Request $request, $user)
    {
        $user = User::where('username', $user)->first();
        if ($user) {
            $calendars = $data = Calendar::where('user_id', $user->id)->get();
            return view('front.calender.calender', compact('calendars'));
        }
        toastr()->warning('User tidak ditemukan.');
        return redirect()->route('home');
    }

    public function get_calendar_by_id(Request $request, $user)
    {
        if($request->ajax()){
            $user = User::where('username', $user)->first();
            
            if ($user) {
                $data = Calendar::where('user_id', $user->id)->get();
                return response()->json($data);
            } else {
                return response()->json(['error' => 'User not found'], 404);
            }
        }
        abort(404);
    }
}
