@extends('layouts.admin')
@section('title', 'Enrollment Applications')
@section('content')
<div class="page-header">
  <h1>Enrollment Applications</h1>
  <p>Manage student enrollment applications and sync to Moodle.</p>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
  <div class="card-body p-0">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Name</th><th>Email</th><th>Phone</th><th>Course</th>
          <th>Status</th><th>Moodle ID</th><th>Applied</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($apps as $app)
          <tr>
            <td>{{ $app->full_name }}</td>
            <td>{{ $app->email }}</td>
            <td>{{ $app->phone ?? '—' }}</td>
            <td>{{ $app->course?->course_name ?? '—' }}</td>
            <td>
              <span class="badge bg-{{ $app->status === 'approved' ? 'success' : ($app->status === 'rejected' ? 'danger' : 'warning') }}">
                {{ ucfirst($app->status) }}
              </span>
            </td>
            <td>{{ $app->moodle_user_id ?? '—' }}</td>
            <td>{{ $app->created_at->format('M d, Y') }}</td>
            <td>
              <button class="btn btn-sm btn-primary" onclick="openEnroll({{ $app->id }}, '{{ addslashes($app->full_name) }}')">
                Enroll in Course
              </button>
            </td>
          </tr>
        @empty
          <tr><td colspan="8" class="text-center py-4 text-muted">No applications yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
{{ $apps->links() }}

{{-- Enroll Modal --}}
<div class="modal fade" id="enrollModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Enroll in Moodle Course</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" id="enrollForm">
        @csrf
        <div class="modal-body">
          <p class="mb-3">Enrolling: <strong id="enrollName"></strong></p>
          <label class="form-label">Select Moodle Course</label>
          <select name="moodle_course_id" class="form-select" id="moodleCourseSelect" required>
            <option value="">Loading courses…</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Enroll Student</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
let moodleCourses = null;

async function loadMoodleCourses() {
  if (moodleCourses) return moodleCourses;
  const res = await fetch('/admin/lms/moodle-courses');
  moodleCourses = await res.json();
  return moodleCourses;
}

async function openEnroll(appId, name) {
  document.getElementById('enrollName').textContent = name;
  document.getElementById('enrollForm').action = '/admin/lms/applications/' + appId + '/approve';

  const select = document.getElementById('moodleCourseSelect');
  select.innerHTML = '<option value="">Loading…</option>';

  const modal = new bootstrap.Modal(document.getElementById('enrollModal'));
  modal.show();

  try {
    const courses = await loadMoodleCourses();
    select.innerHTML = '<option value="">— Select Course —</option>';
    courses.forEach(c => {
      const opt = document.createElement('option');
      opt.value = c.id;
      opt.textContent = c.fullname || c.shortname;
      select.appendChild(opt);
    });
  } catch(e) {
    select.innerHTML = '<option value="">Error loading courses</option>';
  }
}
</script>
@endsection
