@extends('layouts.admin')
@php
  $isEdit = $course->exists;
  $pageTitle = $isEdit ? 'Edit Course' : 'New Course';
  $currentPage = 'courses';
@endphp

@section('content')
<div style="margin-bottom:1rem;">
  <a href="{{ route('admin.courses.index') }}" class="btn-sm btn-outline">← Back to Courses</a>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">{{ $isEdit ? 'Edit: ' . $course->course_name : 'Create New Course' }}</div>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ $isEdit ? route('admin.courses.update', $course) : route('admin.courses.store') }}">
      @csrf
      @if($isEdit) @method('PUT') @endif

      <div class="form-row">
        <div class="form-group">
          <label>Category Tag</label>
          <input type="text" name="category_tag" class="form-control" value="{{ old('category_tag', $course->category_tag) }}" placeholder="e.g. Foundation, Technical, Creative">
        </div>
        <div class="form-group">
          <label>Duration</label>
          <input type="text" name="duration" class="form-control" value="{{ old('duration', $course->duration) }}" placeholder="e.g. 3 – 6 Months">
        </div>
      </div>

      <div class="form-group">
        <label>Course Name <span style="color:#dc2626">*</span></label>
        <input type="text" name="course_name" class="form-control" value="{{ old('course_name', $course->course_name) }}" required placeholder="e.g. Dressmaking">
      </div>

      <div class="form-group">
        <label>Description <span style="color:#dc2626">*</span></label>
        <textarea name="description" class="form-control" rows="4" required>{{ old('description', $course->description) }}</textarea>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Card Gradient (CSS)</label>
          <input type="text" name="card_gradient" id="gradientInput" class="form-control" value="{{ old('card_gradient', $course->card_gradient ?? 'linear-gradient(135deg,#C4886B,#8B4513)') }}" placeholder="linear-gradient(135deg,#C4886B,#8B4513)">
          <div style="margin-top:.5rem;height:32px;border-radius:4px;border:1px solid #ddd;" id="gradientPreview"></div>
        </div>
        <div class="form-group">
          <label>Sort Order</label>
          <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $course->sort_order ?? 0) }}" min="0">
          <div style="margin-top:.75rem;">
            <div class="form-check">
              <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $course->is_active ?? true) ? 'checked' : '' }}>
              <label for="is_active">Course is Active (visible on public site)</label>
            </div>
          </div>
        </div>
      </div>

      <div style="display:flex;gap:.75rem;margin-top:.5rem;">
        <button type="submit" class="btn-sm btn-primary">{{ $isEdit ? 'Update Course' : 'Create Course' }}</button>
        <a href="{{ route('admin.courses.index') }}" class="btn-sm btn-outline">Cancel</a>
      </div>
    </form>
  </div>
</div>

<script>
  const gi = document.getElementById('gradientInput');
  const gp = document.getElementById('gradientPreview');
  function updatePreview() { gp.style.background = gi.value; }
  gi.addEventListener('input', updatePreview);
  updatePreview();
</script>
@endsection
