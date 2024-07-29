<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\SuspendRequest;

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
            $user = User::find($id);
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not found.'], 404);
            }

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

            $userData = [
                'username' => $user->username,
                'profile_image' => $user->profile_image ? asset($user->profile_image) : 'https://caspertopup.com/images/avatars/default.jpg',
                'role' => $user->role
            ];

            return response()->json([
                'status' => true,
                'html' => view('front.message.chat-history', compact('messages'))->render(),
                'userData' => $userData
            ]);
        }
        
        abort(404);
    }

    public function message_send(Request $request)
    {
        if ($request->ajax()) {
            try {
                $request->validate([
                    'to_id' => 'required|exists:users,id|not_in:' . auth()->user()->id,
                    'body' => 'required|string|max:1000',
                ]);

                Message::create([
                    'from_id' => auth()->user()->id,
                    'to_id' => $request->to_id,
                    'body' => $request->body,
                ]);

                return response()->json(['status' => true, 'message' => 'Message sent successfully']);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json(['status' => false, 'message' => 'Terjadi kesalahan saat mengirim pesan.']);
            }
        }
        
        abort(404);
    }

    public function report_user(Request $request)
    {
        $validated = $request->validate([
            'reporter_id' => 'required|exists:users,id',
            'reported_id' => 'required|exists:users,id',
            'note' => 'required|string|max:255',
            'proff' => 'nullable|image|max:2048',
         ]);
   
         if ($request->hasFile('proff')) {
            $path = $request->file('proff')->store('reports', 'public');
            $validated['proff'] = $path;
         }
   
         SuspendRequest::create($validated);
   
         return response()->json(['message' => 'Report submitted successfully'], 200);
    }
}
