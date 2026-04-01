@extends('layouts.admin')
@php $pageTitle = 'Alumni Showcase'; $currentPage = 'alumni'; @endphp

@section('content')
{{-- Existing alumni --}}
<div class="card" style="margin-bottom:1.5rem;">
  <div class="card-header"><div class="card-title">Alumni Showcase Items</div></div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Name / Brand</th>
          <th>Role / Description</th>
          <th>Order</th>
          <th>Active</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($alumni as $a)
        <tr>
          <td><strong>{{ $a->alumni_name }}</strong></td>
          <td>{{ $a->alumni_role }}</td>
          <td>{{ $a->sort_order }}</td>
          <td><span class="badge {{ $a->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $a->is_active ? 'Yes' : 'No' }}</span></td>
          <td>
            <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
              <form method="POST" action="{{ route('admin.alumni.update', $a->id) }}">
                @csrf @method('PUT')
                <div style="display:flex;gap:.4rem;align-items:center;">
                  <input type="text" name="alumni_name" class="form-control" value="{{ $a->alumni_name }}" style="width:160px;">
                  <input type="text" name="alumni_role" class="form-control" value="{{ $a->alumni_role }}" style="width:160px;">
                  <input type="number" name="sort_order" class="form-control" value="{{ $a->sort_order }}" style="width:60px;">
                  <input type="checkbox" name="is_active" value="1" {{ $a->is_active ? 'checked' : '' }} title="Active">
                  <button type="submit" class="btn-sm btn-gold">Save</button>
                </div>
              </form>
              <form method="POST" action="{{ route('admin.alumni.destroy', $a->id) }}" onsubmit="return confirm('Delete this alumni entry?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm btn-danger">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;color:#aaa;padding:2rem;">No alumni entries yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- Add new --}}
<div class="card">
  <div class="card-header"><div class="card-title">Add Alumni Entry</div></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.alumni.store') }}">
      @csrf
      <div class="form-row">
        <div class="form-group">
          <label>Name / Brand</label>
          <input type="text" name="alumni_name" class="form-control" required placeholder="Bench / Suyen Corp">
        </div>
        <div class="form-group">
          <label>Role / Description</label>
          <input type="text" name="alumni_role" class="form-control" required placeholder="Alumni-Founded Brand">
        </div>
      </div>
      <div class="form-group" style="max-width:120px;">
        <label>Sort Order</label>
        <input type="number" name="sort_order" class="form-control" value="{{ $alumni->count() }}">
      </div>
      <button type="submit" class="btn-sm btn-primary">Add Alumni</button>
    </form>
  </div>
</div>
@endsection
