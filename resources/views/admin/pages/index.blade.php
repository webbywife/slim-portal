@extends('layouts.admin')
@php $pageTitle = 'Pages'; $currentPage = 'pages'; @endphp

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
  <h1 style="font-size:1.1rem;font-weight:700;color:#1a1a1a;">Pages</h1>
  <a href="{{ route('admin.pages.create') }}" class="btn-sm btn-primary">+ New Page</a>
</div>

<div class="card">
  <div class="card-body" style="padding:0;">
    @if($pages->isEmpty())
      <div style="padding:3rem;text-align:center;color:#888;">No pages yet. <a href="{{ route('admin.pages.create') }}">Create your first page →</a></div>
    @else
    <table style="width:100%;border-collapse:collapse;font-size:.85rem;">
      <thead>
        <tr style="border-bottom:1px solid #eee;">
          <th style="padding:.75rem 1.25rem;text-align:left;font-weight:600;color:#444;">Title</th>
          <th style="padding:.75rem 1rem;text-align:left;font-weight:600;color:#444;">Slug / URL</th>
          <th style="padding:.75rem 1rem;text-align:center;font-weight:600;color:#444;">Status</th>
          <th style="padding:.75rem 1.25rem;text-align:right;font-weight:600;color:#444;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($pages as $p)
        <tr style="border-bottom:1px solid #f5f5f5;">
          <td style="padding:.75rem 1.25rem;font-weight:500;color:#1a1a1a;">{{ $p->title }}</td>
          <td style="padding:.75rem 1rem;">
            <a href="{{ url('/page/' . $p->slug) }}" target="_blank" style="color:#7c3aed;font-size:.8rem;">/page/{{ $p->slug }} ↗</a>
          </td>
          <td style="padding:.75rem 1rem;text-align:center;">
            @if($p->is_active)
              <span style="background:#dcfce7;color:#166534;font-size:.68rem;font-weight:600;padding:.2rem .6rem;border-radius:20px;letter-spacing:.05em;">ACTIVE</span>
            @else
              <span style="background:#f3f4f6;color:#6b7280;font-size:.68rem;font-weight:600;padding:.2rem .6rem;border-radius:20px;letter-spacing:.05em;">DRAFT</span>
            @endif
          </td>
          <td style="padding:.75rem 1.25rem;text-align:right;">
            <a href="{{ route('admin.pages.edit', $p) }}" class="btn-sm btn-outline" style="margin-right:.4rem;">Edit</a>
            <form method="POST" action="{{ route('admin.pages.destroy', $p) }}" style="display:inline;" onsubmit="return confirm('Delete this page?')">
              @csrf @method('DELETE')
              <button class="btn-sm" style="background:#fee2e2;color:#dc2626;border:1px solid #fca5a5;">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
</div>
@endsection
