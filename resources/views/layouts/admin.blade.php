<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/png" href="/favicon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $pageTitle ?? 'Admin' }} — Slim's CMS</title>
  <style>
    :root {
      --maroon:    #8c1a37;
      --maroon-d:  #550D0E;
      --maroon-db: #2E0A0B;
      --gold:      #C9A84C;
      --gold-l:    #E2C47A;
      --cream:     #FAF6EF;
      --ivory:     #F2EBD9;
      --charcoal:  #2A2020;
      --sidebar-w: 240px;
      --topbar-h:  60px;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; }
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #F4F0EA; color: var(--charcoal); display: flex; }

    /* ─── Sidebar ─── */
    .sidebar {
      width: var(--sidebar-w); min-height: 100vh;
      background: var(--maroon-db);
      display: flex; flex-direction: column;
      position: sticky; top: 0; height: 100vh; overflow-y: auto;
      flex-shrink: 0;
    }
    .sidebar-brand {
      padding: 1.5rem 1.25rem 1rem;
      border-bottom: 1px solid rgba(255,255,255,.07);
    }
    .sidebar-brand-name {
      font-size: .9rem; font-weight: 700; color: #fff;
      line-height: 1.2;
    }
    .sidebar-brand-sub {
      font-size: .65rem; letter-spacing: .15em; text-transform: uppercase;
      color: var(--gold); margin-top: .2rem;
    }
    .sidebar-nav { flex: 1; padding: 1rem 0; }
    .sidebar-section {
      font-size: .58rem; font-weight: 700; letter-spacing: .2em; text-transform: uppercase;
      color: rgba(255,255,255,.25); padding: .75rem 1.25rem .35rem;
    }
    .sidebar-link {
      display: flex; align-items: center; gap: .6rem;
      padding: .6rem 1.25rem;
      font-size: .78rem; font-weight: 500;
      color: rgba(255,255,255,.6);
      text-decoration: none;
      transition: all .15s;
      border-left: 3px solid transparent;
    }
    .sidebar-link:hover, .sidebar-link.active {
      color: #fff;
      background: rgba(255,255,255,.06);
      border-left-color: var(--gold);
    }
    .sidebar-link .icon { width: 16px; height: 16px; flex-shrink: 0; opacity: .7; }
    .sidebar-link:hover .icon, .sidebar-link.active .icon { opacity: 1; }
    .badge-count {
      margin-left: auto;
      background: var(--maroon);
      color: #fff;
      font-size: .62rem; font-weight: 700;
      padding: .15rem .45rem; border-radius: 10px;
      min-width: 20px; text-align: center;
    }
    .sidebar-footer {
      padding: 1rem 1.25rem;
      border-top: 1px solid rgba(255,255,255,.07);
      font-size: .72rem; color: rgba(255,255,255,.35);
    }
    .sidebar-footer a { color: rgba(255,255,255,.5); text-decoration: none; }
    .sidebar-footer a:hover { color: var(--gold); }

    /* ─── Main Area ─── */
    .main-wrap { flex: 1; min-width: 0; display: flex; flex-direction: column; }

    /* ─── Topbar ─── */
    .topbar {
      height: var(--topbar-h); background: #fff;
      border-bottom: 1px solid rgba(0,0,0,.07);
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 1.75rem; gap: 1rem;
      position: sticky; top: 0; z-index: 100;
      box-shadow: 0 1px 4px rgba(0,0,0,.06);
    }
    .topbar-title {
      font-size: 1rem; font-weight: 700; color: var(--charcoal);
    }
    .topbar-right { display: flex; align-items: center; gap: 1rem; }
    .topbar-user {
      font-size: .8rem; color: #666;
    }
    .topbar-user strong { color: var(--charcoal); }
    .btn-sm {
      display: inline-flex; align-items: center; gap: .35rem;
      padding: .4rem .9rem;
      font-size: .72rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
      border: none; cursor: pointer; text-decoration: none;
      border-radius: 3px; transition: all .15s;
    }
    .btn-primary { background: var(--maroon); color: #fff; }
    .btn-primary:hover { background: var(--maroon-d); }
    .btn-gold { background: var(--gold); color: var(--maroon-d); }
    .btn-gold:hover { background: var(--gold-l); }
    .btn-outline { background: transparent; color: var(--charcoal); border: 1px solid #ddd; }
    .btn-outline:hover { border-color: var(--maroon); color: var(--maroon); }
    .btn-danger { background: #dc2626; color: #fff; }
    .btn-danger:hover { background: #b91c1c; }

    /* ─── Content ─── */
    .content { flex: 1; padding: 1.75rem; }

    /* ─── Flash messages ─── */
    .flash {
      padding: .85rem 1.25rem;
      border-radius: 4px; margin-bottom: 1.25rem;
      font-size: .85rem; font-weight: 500;
      display: flex; align-items: center; gap: .75rem;
    }
    .flash-success { background: #f0fdf4; border: 1px solid #86efac; color: #166534; }
    .flash-error   { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }

    /* ─── Cards ─── */
    .card {
      background: #fff; border: 1px solid rgba(0,0,0,.07);
      border-radius: 6px;
      box-shadow: 0 1px 3px rgba(0,0,0,.04);
    }
    .card-header {
      padding: 1rem 1.25rem;
      border-bottom: 1px solid rgba(0,0,0,.06);
      display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    }
    .card-title { font-size: .9rem; font-weight: 700; color: var(--charcoal); }
    .card-body { padding: 1.25rem; }

    /* ─── Tables ─── */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: .82rem; }
    th {
      padding: .7rem 1rem; text-align: left;
      font-size: .65rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
      color: #888; background: #fafafa;
      border-bottom: 1px solid rgba(0,0,0,.08);
    }
    td {
      padding: .75rem 1rem;
      border-bottom: 1px solid rgba(0,0,0,.05);
      vertical-align: middle;
    }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: #fafafa; }

    /* ─── Forms ─── */
    .form-group { margin-bottom: 1rem; }
    .form-group label {
      display: block; margin-bottom: .35rem;
      font-size: .72rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase;
      color: #666;
    }
    .form-control {
      width: 100%; padding: .65rem .85rem;
      border: 1px solid #ddd; border-radius: 4px;
      font-size: .88rem; color: var(--charcoal);
      background: #fff;
      transition: border-color .15s, box-shadow .15s;
      outline: none;
    }
    .form-control:focus { border-color: var(--maroon); box-shadow: 0 0 0 3px rgba(123,18,19,.08); }
    textarea.form-control { resize: vertical; min-height: 100px; }
    .form-check { display: flex; align-items: center; gap: .5rem; margin-top: .25rem; }
    .form-check input[type=checkbox] { width: 16px; height: 16px; accent-color: var(--maroon); }
    .form-check label { font-size: .85rem; color: var(--charcoal); font-weight: 400; letter-spacing: 0; text-transform: none; margin: 0; }
    .form-hint { font-size: .75rem; color: #888; margin-top: .25rem; }
    .form-error { font-size: .75rem; color: #dc2626; margin-top: .25rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }

    /* ─── Badges ─── */
    .badge {
      display: inline-block; padding: .2rem .6rem;
      border-radius: 3px; font-size: .65rem; font-weight: 700;
      letter-spacing: .06em; text-transform: uppercase;
    }
    .badge-admin   { background: #fef3c7; color: #92400e; }
    .badge-staff   { background: #dbeafe; color: #1e40af; }
    .badge-active  { background: #dcfce7; color: #166534; }
    .badge-inactive{ background: #fee2e2; color: #991b1b; }
    .badge-unread  { background: var(--maroon); color: #fff; }
    .badge-read    { background: #e5e7eb; color: #6b7280; }

    /* ─── Tabs ─── */
    .tabs { display: flex; gap: 0; border-bottom: 2px solid #e5e7eb; margin-bottom: 1.5rem; }
    .tab-btn {
      padding: .65rem 1.1rem;
      font-size: .75rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
      color: #888; background: none; border: none; cursor: pointer;
      border-bottom: 2px solid transparent; margin-bottom: -2px;
      transition: all .15s;
    }
    .tab-btn:hover { color: var(--maroon); }
    .tab-btn.active { color: var(--maroon); border-bottom-color: var(--maroon); }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ─── Stats grid ─── */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
    .stat-card {
      background: #fff; border: 1px solid rgba(0,0,0,.07); border-radius: 6px;
      padding: 1.25rem; box-shadow: 0 1px 3px rgba(0,0,0,.04);
    }
    .stat-card .stat-label { font-size: .68rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: #888; margin-bottom: .4rem; }
    .stat-card .stat-value { font-size: 2rem; font-weight: 700; color: var(--maroon); line-height: 1; }
    .stat-card .stat-sub { font-size: .72rem; color: #aaa; margin-top: .3rem; }

    /* ─── Quick actions ─── */
    .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; }
    .quick-tile {
      background: #fff; border: 1px solid rgba(0,0,0,.07); border-radius: 6px;
      padding: 1.25rem; text-align: center; text-decoration: none;
      color: var(--charcoal); transition: all .15s;
      box-shadow: 0 1px 3px rgba(0,0,0,.04);
    }
    .quick-tile:hover { border-color: var(--maroon); box-shadow: 0 4px 12px rgba(123,18,19,.1); transform: translateY(-2px); }
    .quick-tile .tile-icon { font-size: 1.5rem; margin-bottom: .5rem; }
    .quick-tile .tile-label { font-size: .75rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #666; }

    /* ─── Dynamic row (for repeating fields) ─── */
    .dynamic-row {
      display: flex; gap: .5rem; align-items: flex-start;
      margin-bottom: .6rem;
    }
    .dynamic-row .form-control { flex: 1; }
    .btn-remove {
      width: 32px; height: 34px; flex-shrink: 0;
      background: #fee2e2; color: #dc2626; border: none; border-radius: 4px;
      cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center;
    }
    .btn-remove:hover { background: #fca5a5; }
    .btn-add-row {
      background: none; border: 1px dashed #ccc; border-radius: 4px;
      padding: .4rem .9rem; font-size: .75rem; color: #888; cursor: pointer;
      transition: all .15s;
    }
    .btn-add-row:hover { border-color: var(--maroon); color: var(--maroon); }

    /* ─── Pagination ─── */
    .pagination { display: flex; gap: .35rem; margin-top: 1.25rem; justify-content: flex-end; }
    .pagination a, .pagination span {
      padding: .4rem .75rem; border-radius: 4px; font-size: .8rem;
      border: 1px solid #ddd; color: #666; text-decoration: none;
    }
    .pagination a:hover { border-color: var(--maroon); color: var(--maroon); }
    .pagination .active span { background: var(--maroon); border-color: var(--maroon); color: #fff; }

    /* ─── Logout form ─── */
    .logout-form { display: inline; }
    .logout-btn {
      background: none; border: none; cursor: pointer;
      font-size: .72rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
      color: rgba(255,255,255,.5); padding: 0; transition: color .15s;
    }
    .logout-btn:hover { color: #fff; }

    /* ─── Inline img preview ─── */
    .img-preview {
      width: 60px; height: 40px; object-fit: cover; border-radius: 3px;
      border: 1px solid #ddd;
    }
    .img-placeholder {
      width: 60px; height: 40px; border-radius: 3px;
      border: 1px solid #ddd; display: inline-flex; align-items: center; justify-content: center;
      font-size: .65rem; color: #aaa; background: #fafafa;
    }

    /* Section divider */
    .section-divider { border: none; border-top: 1px solid rgba(0,0,0,.07); margin: 1.5rem 0; }

    @media (max-width: 768px) {
      .sidebar { position: fixed; left: -240px; z-index: 200; transition: left .25s; }
      .sidebar.open { left: 0; }
      .form-row, .form-row-3 { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar">
  <div class="sidebar-brand">
    <div class="sidebar-brand-name">Slim's Fashion &amp; Arts</div>
    <div class="sidebar-brand-sub">Admin Panel</div>
  </div>

  <nav class="sidebar-nav">
    <div class="sidebar-section">Main</div>
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ ($currentPage ?? '') === 'dashboard' ? 'active' : '' }}">
      <svg class="icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="1" width="6" height="6" rx="1"/><rect x="9" y="1" width="6" height="6" rx="1"/><rect x="1" y="9" width="6" height="6" rx="1"/><rect x="9" y="9" width="6" height="6" rx="1"/></svg>
      Dashboard
    </a>

    <div class="sidebar-section">Content</div>
    <a href="{{ route('admin.content.index') }}" class="sidebar-link {{ ($currentPage ?? '') === 'content' ? 'active' : '' }}">
      <svg class="icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="1" width="14" height="14" rx="1"/><path d="M4 5h8M4 8h6M4 11h4"/></svg>
      Page Content
    </a>
    <a href="{{ route('admin.courses.index') }}" class="sidebar-link {{ ($currentPage ?? '') === 'courses' ? 'active' : '' }}">
      <svg class="icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 4h12v9a1 1 0 01-1 1H3a1 1 0 01-1-1V4z"/><path d="M5 4V2h6v2"/></svg>
      Courses
    </a>
    <a href="{{ route('admin.pages.index') }}" class="sidebar-link {{ ($currentPage ?? '') === 'pages' ? 'active' : '' }}">
      <svg class="icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 1h7l3 3v11H3V1z"/><path d="M10 1v3h3"/><path d="M5 7h6M5 10h4"/></svg>
      Pages
    </a>
    <a href="{{ route('admin.gallery.index') }}" class="sidebar-link {{ ($currentPage ?? '') === 'gallery' ? 'active' : '' }}">
      <svg class="icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="14" height="10" rx="1"/><circle cx="5.5" cy="7" r="1.5"/><path d="M1 11l4-3 3 2 2-2 5 4"/></svg>
      Gallery
    </a>
    <a href="{{ route('admin.enrollment.index') }}" class="sidebar-link {{ ($currentPage ?? '') === 'enrollment' ? 'active' : '' }}">
      <svg class="icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 2H5a1 1 0 00-1 1v10a1 1 0 001 1h6a1 1 0 001-1V3a1 1 0 00-1-1z"/><path d="M6 6h4M6 9h3"/></svg>
      Enrollment
    </a>
    <a href="{{ route('admin.alumni.index') }}" class="sidebar-link {{ ($currentPage ?? '') === 'alumni' ? 'active' : '' }}">
      <svg class="icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="8" cy="5" r="3"/><path d="M2 14c0-3.3 2.7-6 6-6s6 2.7 6 6"/></svg>
      Alumni
    </a>
    <a href="{{ route('admin.messages.index') }}" class="sidebar-link {{ ($currentPage ?? '') === 'messages' ? 'active' : '' }}">
      <svg class="icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 3h12v9a1 1 0 01-1 1H3a1 1 0 01-1-1V3z"/><path d="M2 3l6 5 6-5"/></svg>
      Messages
      @php $unread = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
      @if($unread > 0)
        <span class="badge-count">{{ $unread }}</span>
      @endif
    </a>

    @if(auth()->user()->isAdmin())
    <div class="sidebar-section">Admin</div>
    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ ($currentPage ?? '') === 'users' ? 'active' : '' }}">
      <svg class="icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="6" cy="5" r="3"/><path d="M1 14c0-2.8 2.2-5 5-5"/><circle cx="12" cy="10" r="3"/><path d="M12 8v4M10 10h4"/></svg>
      Users
    </a>
    @endif

    <div class="sidebar-section">System</div>
    <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ ($currentPage ?? '') === 'settings' ? 'active' : '' }}">
      <svg class="icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="8" cy="8" r="2"/><path d="M8 1v2M8 13v2M1 8h2M13 8h2M3.05 3.05l1.41 1.41M11.54 11.54l1.41 1.41M3.05 12.95l1.41-1.41M11.54 4.46l1.41-1.41"/></svg>
      Settings
    </a>
    <a href="{{ route('admin.scorm-tool') }}" target="_blank" class="sidebar-link">
      <svg class="icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7 3H3a1 1 0 00-1 1v9a1 1 0 001 1h9a1 1 0 001-1V9"/><path d="M10 2h4v4"/><path d="M14 2L8 8"/></svg>
      SCORM Tool ↗
    </a>
  </nav>

  <div class="sidebar-footer">
    <form action="{{ route('logout') }}" method="POST" class="logout-form">
      @csrf
      <button type="submit" class="logout-btn">Sign Out</button>
    </form>
    &nbsp;&middot;&nbsp;
    <a href="{{ route('home') }}" target="_blank">View Site ↗</a>
  </div>
</aside>

{{-- Main --}}
<div class="main-wrap">
  <header class="topbar">
    <div class="topbar-title">{{ $pageTitle ?? 'Dashboard' }}</div>
    <div class="topbar-right">
      <span class="topbar-user">
        Logged in as <strong>{{ auth()->user()->name }}</strong>
        <span class="badge {{ auth()->user()->isAdmin() ? 'badge-admin' : 'badge-staff' }}" style="margin-left:.35rem;">{{ auth()->user()->role }}</span>
      </span>
      <a href="{{ route('home') }}" target="_blank" class="btn-sm btn-outline">View Site ↗</a>
    </div>
  </header>

  <main class="content">
    @if(session('success'))
      <div class="flash flash-success">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 8l3 3 7-7"/></svg>
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="flash flash-error">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="8" r="6"/><path d="M8 5v3M8 11v.5"/></svg>
        {{ session('error') }}
      </div>
    @endif
    @if($errors->any())
      <div class="flash flash-error">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="8" r="6"/><path d="M8 5v3M8 11v.5"/></svg>
        <div>
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      </div>
    @endif

    @yield('content')
  </main>
</div>

<script>
  // Tab switching
  function initTabs(container) {
    const btns = container.querySelectorAll('.tab-btn');
    const panels = container.querySelectorAll('.tab-panel');
    btns.forEach(btn => {
      btn.addEventListener('click', () => {
        btns.forEach(b => b.classList.remove('active'));
        panels.forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        const target = btn.dataset.tab;
        const panel = container.querySelector('.tab-panel[data-tab="' + target + '"]');
        if (panel) panel.classList.add('active');
      });
    });
    if (btns.length) btns[0].click();
  }
  document.querySelectorAll('.tabs-wrap').forEach(initTabs);
</script>
</body>
</html>
