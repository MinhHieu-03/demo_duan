<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use App\Notifications\AdminReplyNotification;


class CommentController extends Controller
{
    
    public function index()
    {
        $newComments = Comment::with(['category', 'user']) // Sử dụng 'category' thay vì 'item'
            ->whereNull('admin_reply')
            ->orderBy('created_at', 'desc')
            ->get();
    
        $repliedComments = Comment::with(['category', 'user'])
            ->whereNotNull('admin_reply')
            ->orderBy('updated_at', 'desc')
            ->get();
    
        return view('admin.comments.index', compact('newComments', 'repliedComments'));
    }

    public function store(Request $request, $categoryId)
    {
        $request->validate([
            'name' => 'required|max:255',
            'comment' => 'required',
        ]);

        $comment = Comment::create([
            'category_id' => $categoryId,
            'user_id' => auth()->id(),
            'name' => $request->name,
            'comment' => $request->comment,
        ]);

        // Gửi thông báo cho admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewCommentNotification($comment));
        }

        return redirect()->back();
    }

    public function reply(Request $request, $commentId)
    {
        $request->validate([
            'admin_reply' => 'required',
        ]);

        $comment = Comment::find($commentId);
        $comment->admin_reply = $request->admin_reply;
        $comment->save();

        // Gửi thông báo cho khách hàng đã bình luận
        if ($comment->user_id) {
            $user = User::find($comment->user_id);
            if ($user) {
                $user->notify(new AdminReplyNotification($comment));
            }
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id); // Tìm bình luận theo ID
        $comment->delete(); // Xóa bình luận
    
        return redirect()->back()->with('success', 'Bình luận đã được xóa thành công.');
    } 
}