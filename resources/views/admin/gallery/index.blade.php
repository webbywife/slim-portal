@extends('layouts.admin')
@php $pageTitle = 'Gallery'; $currentPage = 'gallery'; @endphp

@section('content')
{{-- Upload form --}}
<div class="card" style="margin-bottom:1.5rem;">
  <div class="card-header"><div class="card-title">Upload New Image</div></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-row-3">
        <div class="form-group">
          <label>Image File <span style="color:#dc2626">*</span></label>
          <input type="file" name="image" class="form-control" accept="image/*" required>
          <div class="form-hint">Max 5MB. JPG, PNG, WebP.</div>
        </div>
        <div class="form-group">
          <label>Caption</label>
          <input type="text" name="caption" class="form-control" placeholder="Fashion Show 2024">
        </div>
        <div class="form-group">
          <label>Span Type</label>
          <select name="span_type" class="form-control">
            <option value="normal">Normal (1×1)</option>
            <option value="tall">Tall (1×2)</option>
            <option value="wide">Wide (2×1)</option>
          </select>
        </div>
      </div>
      <button type="submit" class="btn-sm btn-primary">Upload Image</button>
    </form>
  </div>
</div>

{{-- Gallery grid --}}
<div class="card">
  <div class="card-header"><div class="card-title">Gallery Items ({{ $items->count() }})</div></div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Preview</th>
          <th>Caption</th>
          <th>Span</th>
          <th>Order</th>
          <th>Active</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $item)
        <tr>
          <td>
            @if($item->file_path)
              <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->alt_text }}" class="img-preview">
            @else
              <div class="img-placeholder">No img</div>
            @endif
          </td>
          <td>{{ $item->caption ?: '—' }}</td>
          <td><span class="badge badge-staff">{{ $item->span_type }}</span></td>
          <td>{{ $item->sort_order }}</td>
          <td>
            <span class="badge {{ $item->is_active ? 'badge-active' : 'badge-inactive' }}">
              {{ $item->is_active ? 'Yes' : 'No' }}
            </span>
          </td>
          <td>
            <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
              <form method="POST" action="{{ route('admin.gallery.update', $item->id) }}">
                @csrf
                <div style="display:flex;gap:.4rem;align-items:center;">
                  <input type="text" name="caption" class="form-control" value="{{ $item->caption }}" placeholder="Caption" style="width:140px;">
                  <select name="span_type" class="form-control" style="width:90px;">
                    <option value="normal" {{ $item->span_type === 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="tall"   {{ $item->span_type === 'tall'   ? 'selected' : '' }}>Tall</option>
                    <option value="wide"   {{ $item->span_type === 'wide'   ? 'selected' : '' }}>Wide</option>
                  </select>
                  <input type="number" name="sort_order" class="form-control" value="{{ $item->sort_order }}" style="width:60px;">
                  <input type="checkbox" name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }} title="Active">
                  <button type="submit" class="btn-sm btn-gold">Save</button>
                </div>
              </form>
              <form method="POST" action="{{ route('admin.gallery.destroy', $item->id) }}" onsubmit="return confirm('Delete this image?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm btn-danger">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:#aaa;padding:2rem;">No gallery items yet. Upload one above.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
