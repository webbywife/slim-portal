@extends('layouts.admin')
@php $pageTitle = 'Dashboard'; $currentPage = 'dashboard'; @endphp

@section('content')
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-label">Courses</div>
    <div class="stat-value">{{ $stats['courses'] }}</div>
    <div class="stat-sub">Active programs</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Gallery Items</div>
    <div class="stat-value">{{ $stats['gallery'] }}</div>
    <div class="stat-sub">Photos &amp; media</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Total Messages</div>
    <div class="stat-value">{{ $stats['messages'] }}</div>
    <div class="stat-sub">Contact submissions</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Unread Messages</div>
    <div class="stat-value" style="color:{{ $stats['unread'] > 0 ? '#dc2626' : 'var(--maroon)' }}">{{ $stats['unread'] }}</div>
    <div class="stat-sub">Need attention</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Users</div>
    <div class="stat-value">{{ $stats['users'] }}</div>
    <div class="stat-sub">Admin panel users</div>
  </div>
</div>

<div class="card" style="margin-bottom:1.5rem;">
  <div class="card-header">
    <div class="card-title">Quick Actions</div>
  </div>
  <div class="card-body">
    <div class="quick-grid">
      <a href="{{ route('admin.content.index') }}" class="quick-tile">
        <div class="tile-icon">📄</div>
        <div class="tile-label">Page Content</div>
      </a>
      <a href="{{ route('admin.courses.index') }}" class="quick-tile">
        <div class="tile-icon">🎓</div>
        <div class="tile-label">Courses</div>
      </a>
      <a href="{{ route('admin.gallery.index') }}" class="quick-tile">
        <div class="tile-icon">🖼</div>
        <div class="tile-label">Gallery</div>
      </a>
      <a href="{{ route('admin.enrollment.index') }}" class="quick-tile">
        <div class="tile-icon">📋</div>
        <div class="tile-label">Enrollment</div>
      </a>
      <a href="{{ route('admin.alumni.index') }}" class="quick-tile">
        <div class="tile-icon">🏅</div>
        <div class="tile-label">Alumni</div>
      </a>
      <a href="{{ route('admin.messages.index') }}" class="quick-tile">
        <div class="tile-icon">✉️</div>
        <div class="tile-label">Messages</div>
      </a>
      <a href="{{ route('admin.settings.index') }}" class="quick-tile">
        <div class="tile-icon">⚙️</div>
        <div class="tile-label">Settings</div>
      </a>
      <a href="/scorm-tool/index.html" target="_blank" class="quick-tile">
        <div class="tile-icon">📦</div>
        <div class="tile-label">SCORM Builder ↗</div>
      </a>
      @if(auth()->user()->isAdmin())
      <a href="{{ route('admin.users.index') }}" class="quick-tile">
        <div class="tile-icon">👥</div>
        <div class="tile-label">Users</div>
      </a>
      @endif
    </div>
  </div>
</div>
@endsection
