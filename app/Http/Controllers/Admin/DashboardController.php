<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Course, Gallery, ContactMessage, User};

class DashboardController extends Controller {
    public function index() {
        return view('admin.dashboard', [
            'stats' => [
                'courses'  => Course::count(),
                'gallery'  => Gallery::count(),
                'messages' => ContactMessage::count(),
                'unread'   => ContactMessage::where('is_read', false)->count(),
                'users'    => User::count(),
            ],
        ]);
    }
}
