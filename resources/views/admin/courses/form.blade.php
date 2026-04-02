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

<form method="POST" action="{{ $isEdit ? route('admin.courses.update', $course) : route('admin.courses.store') }}" enctype="multipart/form-data">
  @csrf
  @if($isEdit) @method('PUT') @endif

  {{-- Course Details --}}
  <div class="card" style="margin-bottom:1.5rem;">
    <div class="card-header"><div class="card-title">{{ $isEdit ? 'Edit: ' . $course->course_name : 'Create New Course' }}</div></div>
    <div class="card-body">
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
        <input type="text" name="course_name" class="form-control" value="{{ old('course_name', $course->course_name) }}" required>
      </div>
      <div class="form-group">
        <label>Slug <span style="color:#888;font-weight:400;">(URL — auto-generated if blank)</span></label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug', $course->slug) }}" placeholder="e.g. fashion-design" style="font-size:.85rem;">
      </div>
      <div class="form-group">
        <label>Description <span style="color:#dc2626">*</span></label>
        <textarea name="description" class="form-control" rows="4" required>{{ old('description', $course->description) }}</textarea>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Card Gradient (CSS)</label>
          <input type="text" name="card_gradient" id="gradientInput" class="form-control" value="{{ old('card_gradient', $course->card_gradient ?? 'linear-gradient(135deg,#C4886B,#8B4513)') }}">
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
      <div class="form-group">
        <label>Course Image <span style="color:#888;font-weight:400;">(optional)</span></label>
        @if(!empty($course->course_image))
        <div style="margin-bottom:.75rem;">
          <img src="{{ Storage::url($course->course_image) }}" style="max-height:100px;border-radius:6px;border:1px solid #ddd;object-fit:cover;">
        </div>
        @endif
        <input type="file" name="course_image" class="form-control" accept="image/*" onchange="previewCourseImg(this)">
        <img id="course-img-preview" src="" style="display:none;max-height:100px;margin-top:.5rem;border-radius:6px;border:1px solid #ddd;object-fit:cover;">
      </div>
    </div>
  </div>

  {{-- Modules --}}
  <div class="card" style="margin-bottom:1.5rem;">
    <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;">
      <div class="card-title">Modules</div>
      <button type="button" class="btn-sm btn-primary" onclick="addModule()">+ Add Module</button>
    </div>
    <div class="card-body" style="padding:0;">
      <div id="modules-list">
        @forelse($course->modules ?? [] as $mi => $module)
        <div class="module-block" data-module="{{ $mi }}" style="border-bottom:1px solid #f0f0f0;padding:1.5rem;">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
            <strong style="font-size:.85rem;color:#555;">Module {{ $mi + 1 }}</strong>
            <button type="button" class="btn-sm" style="background:#fee2e2;color:#dc2626;border:1px solid #fca5a5;padding:.2rem .6rem;" onclick="this.closest('.module-block').remove()">Remove</button>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label style="font-size:.75rem;">Module Title <span style="color:#dc2626">*</span></label>
              <input type="text" name="modules[{{ $mi }}][title]" class="form-control" value="{{ $module->title }}" placeholder="e.g. Module I Beginners">
            </div>
            <div class="form-group">
              <label style="font-size:.75rem;">Sessions</label>
              <input type="number" name="modules[{{ $mi }}][sessions]" class="form-control" value="{{ $module->sessions }}" placeholder="e.g. 19" min="0">
            </div>
          </div>
          <div class="form-group">
            <label style="font-size:.75rem;">Prerequisite</label>
            <input type="text" name="modules[{{ $mi }}][prerequisite]" class="form-control" value="{{ $module->prerequisite }}" placeholder="e.g. prerequisite Module I">
          </div>
          <div class="form-group">
            <label style="font-size:.75rem;">Description</label>
            <textarea name="modules[{{ $mi }}][description]" class="form-control" rows="3">{{ $module->description }}</textarea>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label style="font-size:.75rem;">Tuition Fee</label>
              <input type="text" name="modules[{{ $mi }}][tuition_fee]" class="form-control" value="{{ $module->tuition_fee }}" placeholder="e.g. approx. ₱24,600">
            </div>
            <div class="form-group">
              <label style="font-size:.75rem;">Materials Fee</label>
              <input type="text" name="modules[{{ $mi }}][materials_fee]" class="form-control" value="{{ $module->materials_fee }}" placeholder="e.g. approx. ₱12,000 or TBA">
            </div>
          </div>

          {{-- Sub-modules --}}
          <div style="margin-top:1rem;padding:1rem;background:#fafafa;border-radius:6px;border:1px solid #eee;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem;">
              <span style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#888;">Sub-modules</span>
              <button type="button" class="btn-sm btn-outline" style="font-size:.72rem;padding:.2rem .6rem;" onclick="addSubmodule({{ $mi }})">+ Add Sub-module</button>
            </div>
            <div id="submodules-{{ $mi }}">
              @foreach($module->submodules as $si => $sub)
              <div class="submodule-row" style="display:grid;grid-template-columns:1fr 2fr auto;gap:.5rem;margin-bottom:.5rem;align-items:start;">
                <input type="text" name="modules[{{ $mi }}][submodules][{{ $si }}][title]" class="form-control" value="{{ $sub->title }}" placeholder="Sub-module title" style="font-size:.82rem;">
                <input type="text" name="modules[{{ $mi }}][submodules][{{ $si }}][description]" class="form-control" value="{{ $sub->description }}" placeholder="Description" style="font-size:.82rem;">
                <button type="button" style="background:#fee2e2;color:#dc2626;border:1px solid #fca5a5;border-radius:4px;padding:.35rem .5rem;cursor:pointer;" onclick="this.closest('.submodule-row').remove()">×</button>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        @empty
        <div style="padding:2rem;text-align:center;color:#aaa;font-size:.85rem;">No modules yet. Click "+ Add Module" to get started.</div>
        @endforelse
      </div>
    </div>
  </div>

  <div style="display:flex;gap:.75rem;">
    <button type="submit" class="btn-sm btn-primary">{{ $isEdit ? 'Update Course' : 'Create Course' }}</button>
    <a href="{{ route('admin.courses.index') }}" class="btn-sm btn-outline">Cancel</a>
  </div>
</form>

<script>
let moduleIdx = {{ ($course->modules ?? collect())->count() }};

function addModule() {
  const mi = moduleIdx++;
  const html = `
  <div class="module-block" data-module="${mi}" style="border-bottom:1px solid #f0f0f0;padding:1.5rem;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
      <strong style="font-size:.85rem;color:#555;">Module</strong>
      <button type="button" class="btn-sm" style="background:#fee2e2;color:#dc2626;border:1px solid #fca5a5;padding:.2rem .6rem;" onclick="this.closest('.module-block').remove()">Remove</button>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label style="font-size:.75rem;">Module Title *</label>
        <input type="text" name="modules[${mi}][title]" class="form-control" placeholder="e.g. Module I Beginners">
      </div>
      <div class="form-group">
        <label style="font-size:.75rem;">Sessions</label>
        <input type="number" name="modules[${mi}][sessions]" class="form-control" placeholder="e.g. 19" min="0">
      </div>
    </div>
    <div class="form-group">
      <label style="font-size:.75rem;">Prerequisite</label>
      <input type="text" name="modules[${mi}][prerequisite]" class="form-control" placeholder="e.g. prerequisite Module I">
    </div>
    <div class="form-group">
      <label style="font-size:.75rem;">Description</label>
      <textarea name="modules[${mi}][description]" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label style="font-size:.75rem;">Tuition Fee</label>
        <input type="text" name="modules[${mi}][tuition_fee]" class="form-control" placeholder="e.g. approx. ₱24,600">
      </div>
      <div class="form-group">
        <label style="font-size:.75rem;">Materials Fee</label>
        <input type="text" name="modules[${mi}][materials_fee]" class="form-control" placeholder="e.g. approx. ₱12,000 or TBA">
      </div>
    </div>
    <div style="margin-top:1rem;padding:1rem;background:#fafafa;border-radius:6px;border:1px solid #eee;">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem;">
        <span style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#888;">Sub-modules</span>
        <button type="button" class="btn-sm btn-outline" style="font-size:.72rem;padding:.2rem .6rem;" onclick="addSubmodule(${mi})">+ Add Sub-module</button>
      </div>
      <div id="submodules-${mi}"></div>
    </div>
  </div>`;
  const list = document.getElementById('modules-list');
  const empty = list.querySelector('[style*="No modules"]');
  if (empty) empty.remove();
  list.insertAdjacentHTML('beforeend', html);
}

const subIdx = {};
function addSubmodule(mi) {
  if (!subIdx[mi]) subIdx[mi] = document.querySelectorAll(`#submodules-${mi} .submodule-row`).length;
  const si = subIdx[mi]++;
  const html = `
  <div class="submodule-row" style="display:grid;grid-template-columns:1fr 2fr auto;gap:.5rem;margin-bottom:.5rem;align-items:start;">
    <input type="text" name="modules[${mi}][submodules][${si}][title]" class="form-control" placeholder="Sub-module title" style="font-size:.82rem;">
    <input type="text" name="modules[${mi}][submodules][${si}][description]" class="form-control" placeholder="Description" style="font-size:.82rem;">
    <button type="button" style="background:#fee2e2;color:#dc2626;border:1px solid #fca5a5;border-radius:4px;padding:.35rem .5rem;cursor:pointer;" onclick="this.closest('.submodule-row').remove()">×</button>
  </div>`;
  document.getElementById(`submodules-${mi}`).insertAdjacentHTML('beforeend', html);
}

function previewCourseImg(input) {
  const p = document.getElementById('course-img-preview');
  if (input.files && input.files[0]) { p.src = URL.createObjectURL(input.files[0]); p.style.display = 'block'; }
}
const gi = document.getElementById('gradientInput');
const gp = document.getElementById('gradientPreview');
function updatePreview() { gp.style.background = gi.value; }
gi.addEventListener('input', updatePreview);
updatePreview();
</script>
@endsection
