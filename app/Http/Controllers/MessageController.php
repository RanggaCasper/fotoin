<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function view_message()
    {
        $getChatUsers = Message::getChatUsers();
        $messages = Message::with('user')->orderBy('created_at', 'asc')->get();
        return view('front.message.message', compact('getChatUsers','messages'));
    }

    public function message_user(Request $request, $id)
    {
        if ($request->ajax()) {
            $messages = Message::with('user')
                        ->where(function ($query) use ($id) {
                            $query->where('from_id', auth()->user()->id)
                                ->where('to_id', $id);
                        })
                        ->orWhere(function ($query) use ($id) {
                            $query->where('from_id', $id)
                                ->where('to_id', auth()->user()->id);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get()
                        ->groupBy(function($date) {
                            return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d');
                        });

            foreach ($messages as $messageGroup) {
                foreach ($messageGroup as $message) {
                    if ($message->from_id == auth()->user()->id && $message->seen == 0) {
                        $message->seen = 1;
                        $message->save();
                    }
                }
            }

            $user = User::find($id);
            $userData = [
                'username' => $user->username,
                'profile_image' => $user->profile_image ? asset($user->profile_image) : 'https://caspertopup.com/images/avatars/default.jpg',
                'role' => $user->role
            ];

            return response()->json([
                'html' => view('front.message.chat-history', compact('messages'))->render(),
                'userData' => $userData
            ]);
        }
        
        abort(404);
    }

    public function message_send(Request $request)
    {
        Message::create([
            'from_id' => auth()->user()->id,
            'to_id' => $request->to_id,
            'body' => $request->body
        ]);

        // // Return a response if necessary (optional)
        return response()->json(['message' => $request->all()]);
    }

}
