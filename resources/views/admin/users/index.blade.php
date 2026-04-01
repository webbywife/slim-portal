@extends('layouts.admin')
@php $pageTitle = 'Users'; $currentPage = 'users'; @endphp

@section('content')
<div class="card">
  <div class="card-header">
    <div class="card-title">Admin Panel Users</div>
    <a href="{{ route('admin.users.create') }}" class="btn-sm btn-primary">+ Add User</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Status</th>
          <th>Last Login</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr>
          <td>
            <strong>{{ $user->name }}</strong>
            @if($user->id === auth()->id())
              <span class="badge badge-active" style="margin-left:.35rem;">You</span>
            @endif
          </td>
          <td>{{ $user->email }}</td>
          <td><span class="badge {{ $user->isAdmin() ? 'badge-admin' : 'badge-staff' }}">{{ $user->role }}</span></td>
          <td><span class="badge {{ $user->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
          <td style="font-size:.78rem;color:#888;">
            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
          </td>
          <td>
            <div style="display:flex;gap:.5rem;">
              <a href="{{ route('admin.users.edit', $user) }}" class="btn-sm btn-outline">Edit</a>
              @if($user->id !== auth()->id())
              <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete user {{ $user->name }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm btn-danger">Delete</button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:#aaa;padding:2rem;">No users found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
