@extends('layouts.admin')
@php $pageTitle = 'Courses'; $currentPage = 'courses'; @endphp

@section('content')
<div class="card">
  <div class="card-header">
    <div class="card-title">All Courses</div>
    <a href="{{ route('admin.courses.create') }}" class="btn-sm btn-primary">+ Add New Course</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Category</th>
          <th>Course Name</th>
          <th>Duration</th>
          <th>Order</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($courses as $course)
        <tr>
          <td>
            <span class="badge badge-staff">{{ $course->category_tag ?: '—' }}</span>
          </td>
          <td>
            <div style="display:flex;align-items:center;gap:.75rem;">
              <div style="width:32px;height:24px;border-radius:3px;background:{{ $course->card_gradient }};flex-shrink:0;"></div>
              <strong>{{ $course->course_name }}</strong>
            </div>
          </td>
          <td>{{ $course->duration ?: '—' }}</td>
          <td>{{ $course->sort_order }}</td>
          <td>
            <span class="badge {{ $course->is_active ? 'badge-active' : 'badge-inactive' }}">
              {{ $course->is_active ? 'Active' : 'Inactive' }}
            </span>
          </td>
          <td>
            <div style="display:flex;gap:.5rem;">
              <a href="{{ route('admin.courses.edit', $course) }}" class="btn-sm btn-outline">Edit</a>
              <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('Delete this course?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm btn-danger">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:#aaa;padding:2rem;">No courses yet. <a href="{{ route('admin.courses.create') }}">Add the first one.</a></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
