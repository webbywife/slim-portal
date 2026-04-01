@extends('layouts.admin')
@php $pageTitle = 'Contact Messages'; $currentPage = 'messages'; @endphp

@section('content')
<div class="card">
  <div class="card-header">
    <div class="card-title">Contact Form Submissions</div>
    <span style="font-size:.8rem;color:#888;">{{ $messages->total() }} total, {{ $messages->where('is_read', false)->count() }} unread on this page</span>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Inquiry</th>
          <th>Message</th>
          <th>Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($messages as $msg)
        <tr style="{{ !$msg->is_read ? 'background:#FFFBF0;' : '' }}">
          <td>
            @if(!$msg->is_read)
              <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:var(--maroon);margin-right:.4rem;vertical-align:middle;"></span>
            @endif
            <strong>{{ $msg->full_name }}</strong>
          </td>
          <td><a href="mailto:{{ $msg->email }}" style="color:var(--maroon);">{{ $msg->email }}</a></td>
          <td>{{ $msg->inquiry_type ?: '—' }}</td>
          <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Str::limit($msg->message, 80) }}</td>
          <td style="white-space:nowrap;font-size:.78rem;color:#888;">{{ $msg->created_at->format('M d, Y') }}<br>{{ $msg->created_at->format('H:i') }}</td>
          <td>
            <span class="badge {{ $msg->is_read ? 'badge-read' : 'badge-unread' }}">
              {{ $msg->is_read ? 'Read' : 'Unread' }}
            </span>
          </td>
          <td>
            <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
              @if(!$msg->is_read)
              <form method="POST" action="{{ route('admin.messages.read', $msg->id) }}">
                @csrf
                <button type="submit" class="btn-sm btn-outline">Mark Read</button>
              </form>
              @endif
              <button type="button" class="btn-sm btn-outline"
                onclick="document.getElementById('msg-{{ $msg->id }}').style.display = document.getElementById('msg-{{ $msg->id }}').style.display === 'none' ? 'block' : 'none'">
                View
              </button>
              <form method="POST" action="{{ route('admin.messages.destroy', $msg->id) }}" onsubmit="return confirm('Delete this message?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm btn-danger">Delete</button>
              </form>
            </div>
            <div id="msg-{{ $msg->id }}" style="display:none;margin-top:.75rem;padding:.75rem;background:#f9f9f9;border-radius:4px;font-size:.82rem;line-height:1.6;max-width:360px;border:1px solid #eee;">
              {{ $msg->message }}
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;color:#aaa;padding:2rem;">No messages yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($messages->hasPages())
  <div style="padding:1rem 1.25rem;border-top:1px solid rgba(0,0,0,.05);">
    {{ $messages->links() }}
  </div>
  @endif
</div>
@endsection
