<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\CustomerMessageNotification;
use App\Notifications\AdminReplyMessagesNotification;

class MessageController extends Controller {
    public function index() {
        $messages = Message::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('messages.index', compact('messages'));
    }

    public function store(Request $request) {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);
    
        // Lưu tin nhắn vào database và gán vào biến $message
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);
    
        // Gửi thông báo đến admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new CustomerMessageNotification($message->message));
        }
    
        return redirect()->back()->with('success', 'Tin nhắn đã được gửi!');
    }

    
public function adminIndex(Request $request)
{
    // Lấy danh sách người đã nhắn tin với admin
    $senders = Message::where('receiver_id', Auth::id()) // Tin nhắn gửi đến admin
        ->orWhere('sender_id', Auth::id()) // Tin nhắn admin gửi đi
        ->with('sender')
        ->get()
        ->pluck('sender')
        ->unique();

    // Lấy tin nhắn theo người dùng được chọn
    $messages = Message::where(function ($query) use ($request) {
        $query->where('sender_id', $request->sender_id)
            ->where('receiver_id', Auth::id());
    })->orWhere(function ($query) use ($request) {
        $query->where('sender_id', Auth::id())
            ->where('receiver_id', $request->sender_id);
    })->orderBy('created_at', 'asc')->get();
    

    return view('admin.messages.index', compact('senders', 'messages'));
}
    public function reply(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);
        
        // Gửi thông báo đến khách hàng
        $customer = User::find($request->receiver_id);
        if ($customer) {
            $customer->notify(new AdminReplyMessagesNotification($message->message));
        }
        
        

        return redirect()->back()->with('success', 'Tin nhắn đã được gửi!');
    }

}
