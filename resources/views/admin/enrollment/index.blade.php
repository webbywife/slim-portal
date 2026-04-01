@extends('layouts.admin')
@php $pageTitle = 'Enrollment'; $currentPage = 'enrollment'; @endphp

@section('content')
<div class="card">
  <div class="card-header"><div class="card-title">Enrollment Section</div></div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.enrollment.update') }}">
      @csrf

      <div class="form-row">
        <div class="form-group">
          <label>Section Label</label>
          <input type="text" name="section_label" class="form-control" value="{{ old('section_label', $section->section_label ?? '') }}" placeholder="Enrollment">
        </div>
        <div class="form-group">
          <label>Heading</label>
          <input type="text" name="heading" class="form-control" value="{{ old('heading', $section->heading ?? '') }}" required>
        </div>
      </div>
      <div class="form-group">
        <label>Body Text</label>
        <textarea name="body_text" class="form-control" rows="3">{{ old('body_text', $section->body_text ?? '') }}</textarea>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>CTA Button Text</label>
          <input type="text" name="cta_text" class="form-control" value="{{ old('cta_text', $section->cta_text ?? '') }}" placeholder="Inquire Now">
        </div>
        <div class="form-group">
          <label>CTA Button URL</label>
          <input type="text" name="cta_url" class="form-control" value="{{ old('cta_url', $section->cta_url ?? '') }}" placeholder="#contact">
        </div>
      </div>

      <hr class="section-divider">
      <h3 style="font-size:.82rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#666;margin-bottom:1rem;">Enrollment Steps</h3>
      <div id="steps-list">
        @foreach($steps as $i => $step)
        <div class="dynamic-row">
          <input type="text" name="steps[{{ $i }}][step_title]" class="form-control" value="{{ $step->step_title }}" placeholder="Choose a Program">
          <input type="text" name="steps[{{ $i }}][step_desc]" class="form-control" value="{{ $step->step_desc }}" placeholder="Description">
          <button type="button" class="btn-remove" onclick="this.parentNode.remove()">×</button>
        </div>
        @endforeach
      </div>
      <button type="button" class="btn-add-row" onclick="addStep()" style="margin-bottom:1.5rem;">+ Add Step</button>

      <hr class="section-divider">
      <div class="form-row">
        <div class="form-group">
          <label>Requirements Card Title</label>
          <input type="text" name="req_card_title" class="form-control" value="{{ old('req_card_title', $section->req_card_title ?? '') }}" placeholder="Enrollment Requirements">
        </div>
      </div>
      <div class="form-group">
        <label>Requirements Note</label>
        <textarea name="req_note" class="form-control" rows="3">{{ old('req_note', $section->req_note ?? '') }}</textarea>
      </div>

      <h3 style="font-size:.82rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#666;margin-bottom:1rem;">Requirements List</h3>
      <div id="req-list">
        @foreach($requirements as $i => $req)
        <div class="dynamic-row">
          <input type="text" name="requirements[{{ $i }}]" class="form-control" value="{{ $req->requirement }}" placeholder="Requirement">
          <button type="button" class="btn-remove" onclick="this.parentNode.remove()">×</button>
        </div>
        @endforeach
      </div>
      <button type="button" class="btn-add-row" onclick="addReq()" style="margin-bottom:1rem;">+ Add Requirement</button>

      <hr class="section-divider">
      <button type="submit" class="btn-sm btn-primary">Save Enrollment Section</button>
    </form>
  </div>
</div>

<script>
let stepIdx = {{ $steps->count() }};
let reqIdx  = {{ $requirements->count() }};
function addStep() {
  const d = document.createElement('div'); d.className = 'dynamic-row';
  d.innerHTML = `<input type="text" name="steps[${stepIdx}][step_title]" class="form-control" placeholder="Step Title"><input type="text" name="steps[${stepIdx}][step_desc]" class="form-control" placeholder="Step Description"><button type="button" class="btn-remove" onclick="this.parentNode.remove()">×</button>`;
  document.getElementById('steps-list').appendChild(d); stepIdx++;
}
function addReq() {
  const d = document.createElement('div'); d.className = 'dynamic-row';
  d.innerHTML = `<input type="text" name="requirements[${reqIdx}]" class="form-control" placeholder="Requirement"><button type="button" class="btn-remove" onclick="this.parentNode.remove()">×</button>`;
  document.getElementById('req-list').appendChild(d); reqIdx++;
}
</script>
@endsection
