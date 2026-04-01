<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class MessageController extends Controller {
    public function index() {
        return view('admin.messages.index', ['messages' => ContactMessage::latest()->paginate(20)]);
    }
    public function markRead(int $id) {
        ContactMessage::findOrFail($id)->update(['is_read' => true]);
        return back()->with('success', 'Marked as read.');
    }
    public function destroy(int $id) {
        ContactMessage::findOrFail($id)->delete();
        return back()->with('success', 'Message deleted.');
    }
}
