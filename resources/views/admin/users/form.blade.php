@extends('layouts.admin')
@php
  $isEdit = $user->exists;
  $pageTitle = $isEdit ? 'Edit User' : 'New User';
  $currentPage = 'users';
@endphp

@section('content')
<div style="margin-bottom:1rem;">
  <a href="{{ route('admin.users.index') }}" class="btn-sm btn-outline">← Back to Users</a>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">{{ $isEdit ? 'Edit: ' . $user->name : 'Create New User' }}</div>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ $isEdit ? route('admin.users.update', $user) : route('admin.users.store') }}">
      @csrf
      @if($isEdit) @method('PUT') @endif

      <div class="form-row">
        <div class="form-group">
          <label>Full Name <span style="color:#dc2626">*</span></label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="form-group">
          <label>Email Address <span style="color:#dc2626">*</span></label>
          <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Role <span style="color:#dc2626">*</span></label>
          <select name="role" class="form-control">
            <option value="staff"  {{ old('role', $user->role) === 'staff'  ? 'selected' : '' }}>Staff — Can edit content, cannot manage users</option>
            <option value="admin"  {{ old('role', $user->role) === 'admin'  ? 'selected' : '' }}>Admin — Full access</option>
          </select>
        </div>
        <div class="form-group">
          <label>&nbsp;</label>
          <div class="form-check" style="margin-top:.65rem;">
            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
            <label for="is_active">Account is Active</label>
          </div>
        </div>
      </div>

      <hr class="section-divider">
      <p style="font-size:.82rem;color:#888;margin-bottom:.75rem;">
        {{ $isEdit ? 'Leave password blank to keep the current password.' : 'Set a strong password.' }}
      </p>
      <div class="form-row">
        <div class="form-group">
          <label>Password {{ $isEdit ? '(optional)' : '' }} <span style="color:#dc2626">{{ !$isEdit ? '*' : '' }}</span></label>
          <input type="password" name="password" class="form-control" {{ !$isEdit ? 'required' : '' }} autocomplete="new-password">
          <div class="form-hint">Minimum 8 characters.</div>
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
        </div>
      </div>

      <div style="display:flex;gap:.75rem;margin-top:.5rem;">
        <button type="submit" class="btn-sm btn-primary">{{ $isEdit ? 'Update User' : 'Create User' }}</button>
        <a href="{{ route('admin.users.index') }}" class="btn-sm btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection
