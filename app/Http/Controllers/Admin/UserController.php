<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function index() {
        return view('admin.users.index', ['users' => User::orderBy('name')->get()]);
    }
    public function create() {
        return view('admin.users.form', ['user' => new User]);
    }
    public function store(Request $request) {
        $d = $request->validate([
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|unique:users|max:180',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:admin,staff',
            'is_active'=> 'boolean',
        ]);
        $d['password']  = Hash::make($d['password']);
        $d['is_active'] = $request->boolean('is_active', true);
        User::create($d);
        return redirect()->route('admin.users.index')->with('success', 'User created.');
    }
    public function edit(User $user) {
        return view('admin.users.form', compact('user'));
    }
    public function update(Request $request, User $user) {
        $d = $request->validate([
            'name'     => 'required|string|max:150',
            'email'    => 'required|email|max:180|unique:users,email,'.$user->id,
            'role'     => 'required|in:admin,staff',
            'is_active'=> 'boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        if (empty($d['password'])) unset($d['password']);
        else $d['password'] = Hash::make($d['password']);
        $d['is_active'] = $request->boolean('is_active');
        $user->update($d);
        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }
    public function destroy(User $user) {
        if ($user->id === auth()->id()) return back()->with('error', 'Cannot delete your own account.');
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
}
