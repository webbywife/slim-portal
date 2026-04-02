@extends('layouts.admin')
@php
  $isEdit = $page->exists;
  $pageTitle = $isEdit ? 'Edit Page' : 'New Page';
  $currentPage = 'pages';
@endphp

@section('content')
<div style="margin-bottom:1rem;">
  <a href="{{ route('admin.pages.index') }}" class="btn-sm btn-outline">← Back to Pages</a>
</div>

<form method="POST" action="{{ $isEdit ? route('admin.pages.update', $page) : route('admin.pages.store') }}" enctype="multipart/form-data">
  @csrf
  @if($isEdit) @method('PUT') @endif

  <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start;">

    {{-- Left: main content --}}
    <div>
      <div class="card" style="margin-bottom:1.25rem;">
        <div class="card-header"><div class="card-title">Page Content</div></div>
        <div class="card-body">
          <div class="form-group">
            <label>Page Title <span style="color:#dc2626">*</span></label>
            <input type="text" name="title" id="pageTitle" class="form-control" value="{{ old('title', $page->title) }}" required placeholder="e.g. About Our School">
          </div>
          <div class="form-group">
            <label>Excerpt <span style="color:#888;font-weight:400;">(optional short summary)</span></label>
            <textarea name="excerpt" class="form-control" rows="2" maxlength="300" placeholder="Brief description shown in previews...">{{ old('excerpt', $page->excerpt) }}</textarea>
          </div>
          <div class="form-group">
            <label>Page Body</label>
            <div id="editor" style="min-height:320px;border:1px solid #ddd;border-radius:6px;background:#fff;"></div>
            <input type="hidden" name="content" id="contentInput" value="{{ old('content', $page->content) }}">
          </div>
        </div>
      </div>
    </div>

    {{-- Right: settings --}}
    <div>
      <div class="card" style="margin-bottom:1.25rem;">
        <div class="card-header"><div class="card-title">Publish</div></div>
        <div class="card-body">
          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $page->is_active ?? true) ? 'checked' : '' }}>
              <label for="is_active">Page is Active (publicly visible)</label>
            </div>
          </div>
          <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $page->sort_order ?? 0) }}" min="0">
          </div>
          <div style="display:flex;gap:.75rem;flex-direction:column;margin-top:.25rem;">
            <button type="submit" class="btn-sm btn-primary">{{ $isEdit ? 'Update Page' : 'Create Page' }}</button>
            <a href="{{ route('admin.pages.index') }}" class="btn-sm btn-outline" style="text-align:center;">Cancel</a>
          </div>
        </div>
      </div>

      <div class="card" style="margin-bottom:1.25rem;">
        <div class="card-header"><div class="card-title">Hero Image</div></div>
        <div class="card-body">
          @if(!empty($page->hero_image))
          <div style="margin-bottom:.75rem;">
            <img src="{{ Storage::url($page->hero_image) }}" style="width:100%;border-radius:6px;border:1px solid #ddd;object-fit:cover;max-height:120px;">
            <div style="font-size:.72rem;color:#888;margin-top:.3rem;">Current hero image</div>
          </div>
          @endif
          <input type="file" name="hero_image" class="form-control" accept="image/*" onchange="previewHero(this)">
          <img id="hero-preview" src="" style="display:none;width:100%;margin-top:.5rem;border-radius:6px;border:1px solid #ddd;object-fit:cover;max-height:120px;">
          <div class="form-hint" style="margin-top:.4rem;">Max 5 MB. Landscape 1920×600px recommended.</div>
        </div>
      </div>

      <div class="card">
        <div class="card-header"><div class="card-title">SEO</div></div>
        <div class="card-body">
          <div class="form-group">
            <label>Slug <span style="color:#888;font-weight:400;">(URL)</span></label>
            <div style="display:flex;align-items:center;gap:.4rem;">
              <span style="font-size:.75rem;color:#888;white-space:nowrap;">/page/</span>
              <input type="text" name="slug" id="slugInput" class="form-control" value="{{ old('slug', $page->slug) }}" placeholder="auto-generated" style="font-size:.82rem;">
            </div>
            <div class="form-hint">Lowercase letters, numbers and hyphens only. Leave blank to auto-generate.</div>
          </div>
          <div class="form-group">
            <label>Meta Description</label>
            <textarea name="meta_description" class="form-control" rows="3" maxlength="300" placeholder="Brief description for search engines...">{{ old('meta_description', $page->meta_description) }}</textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

{{-- Quill rich text editor --}}
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
  const quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
      toolbar: [
        [{ header: [2, 3, 4, false] }],
        ['bold', 'italic', 'underline'],
        [{ list: 'ordered' }, { list: 'bullet' }],
        ['link', 'image'],
        ['blockquote'],
        ['clean']
      ]
    },
    placeholder: 'Write your page content here...'
  });

  // Load existing content
  const existing = document.getElementById('contentInput').value;
  if (existing) quill.root.innerHTML = existing;

  // On submit, copy Quill HTML to hidden input
  document.querySelector('form').addEventListener('submit', function() {
    document.getElementById('contentInput').value = quill.root.innerHTML;
  });

  // Auto-generate slug from title
  const titleInput = document.getElementById('pageTitle');
  const slugInput  = document.getElementById('slugInput');
  titleInput.addEventListener('input', function() {
    if (!slugInput.dataset.manual) {
      slugInput.value = titleInput.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    }
  });
  slugInput.addEventListener('input', function() {
    slugInput.dataset.manual = '1';
  });

  function previewHero(input) {
    const preview = document.getElementById('hero-preview');
    if (input.files && input.files[0]) {
      preview.src = URL.createObjectURL(input.files[0]);
      preview.style.display = 'block';
    }
  }
</script>

<style>
  .ql-container { font-size: .9rem; }
  .ql-editor { min-height: 300px; line-height: 1.7; }
</style>
@endsection
