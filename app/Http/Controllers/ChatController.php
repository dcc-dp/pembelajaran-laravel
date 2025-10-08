<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->take(50)->get()->reverse();
        return view('chat', compact('messages'));
    }

        public function sendMessage(Request $request)
        {
            $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            return response()->json(['status' => 'Message sent!', 'message' => '']);
        }

    public function getMessages()
    {
        $messages = Message::latest()->take(50)->get()->reverse();
        return response()->json($messages);
    }
}