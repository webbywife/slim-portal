@extends('layouts.admin')
@php $pageTitle = 'Settings'; $currentPage = 'settings'; @endphp

@section('content')
<div class="tabs-wrap">
  <div class="tabs">
    <button class="tab-btn" data-tab="global">Global</button>
    <button class="tab-btn" data-tab="contact">Contact Info</button>
    <button class="tab-btn" data-tab="footer">Footer</button>
    <button class="tab-btn" data-tab="social">Social Links</button>
  </div>

  {{-- Global --}}
  <div class="tab-panel" data-tab="global">
    <div class="card">
      <div class="card-header"><div class="card-title">Global Site Settings</div></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update', 'global') }}">
          @csrf
          <div class="form-group">
            <label>Site Name</label>
            <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $siteName) }}">
          </div>
          <div class="form-group">
            <label>Site Tagline</label>
            <input type="text" name="site_tagline" class="form-control" value="{{ old('site_tagline', $siteTagline) }}" placeholder="School · Est. 1962">
          </div>
          <div class="form-group">
            <label>Moodle / Online Platform URL</label>
            <input type="url" name="moodle_url" class="form-control" value="{{ old('moodle_url', $moodleUrl) }}" placeholder="https://slimsonline.school/moodle">
            <div class="form-hint">Used as fallback in CTAs that link to the online platform.</div>
          </div>
          <button type="submit" class="btn-sm btn-primary">Save Global Settings</button>
        </form>
      </div>
    </div>
  </div>

  {{-- Contact --}}
  <div class="tab-panel" data-tab="contact">
    <div class="card">
      <div class="card-header"><div class="card-title">Contact Information</div></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update', 'contact') }}">
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label>Email Address</label>
              <input type="email" name="email" class="form-control" value="{{ old('email', $contact->email ?? '') }}" required>
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="text" name="phone" class="form-control" value="{{ old('phone', $contact->phone ?? '') }}" placeholder="+63 (2) 8XXX-XXXX">
            </div>
          </div>
          <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $contact->address ?? '') }}" placeholder="Metro Manila, Philippines">
          </div>
          <div class="form-group">
            <label>Office Hours</label>
            <input type="text" name="office_hours" class="form-control" value="{{ old('office_hours', $contact->office_hours ?? '') }}" placeholder="Monday – Saturday, 8:00 AM – 5:00 PM">
          </div>
          <button type="submit" class="btn-sm btn-primary">Save Contact Info</button>
        </form>
      </div>
    </div>
  </div>

  {{-- Footer --}}
  <div class="tab-panel" data-tab="footer">
    <div class="card">
      <div class="card-header"><div class="card-title">Footer Content</div></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update', 'footer') }}">
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label>Brand Name</label>
              <input type="text" name="brand_name" class="form-control" value="{{ old('brand_name', $footer->brand_name ?? '') }}" required>
            </div>
            <div class="form-group">
              <label>Brand Subtitle</label>
              <input type="text" name="brand_sub" class="form-control" value="{{ old('brand_sub', $footer->brand_sub ?? '') }}" placeholder="Est. 1962 · Metro Manila, Philippines">
            </div>
          </div>
          <div class="form-group">
            <label>Brand Blurb</label>
            <textarea name="brand_blurb" class="form-control" rows="3">{{ old('brand_blurb', $footer->brand_blurb ?? '') }}</textarea>
          </div>
          <div class="form-group">
            <label>Copyright Text</label>
            <input type="text" name="copyright_text" class="form-control" value="{{ old('copyright_text', $footer->copyright_text ?? '') }}" placeholder="© 2025 Slim's Fashion & Arts School. All rights reserved.">
          </div>
          <button type="submit" class="btn-sm btn-primary">Save Footer</button>
        </form>
      </div>
    </div>
  </div>

  {{-- Social Links --}}
  <div class="tab-panel" data-tab="social">
    <div class="card">
      <div class="card-header"><div class="card-title">Social Media Links</div></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update', 'social') }}">
          @csrf
          <p style="font-size:.82rem;color:#888;margin-bottom:1rem;">Platform options: facebook, instagram, tiktok, twitter, youtube, linkedin</p>
          <div id="social-list">
            @foreach($socialLinks as $i => $link)
            <div class="dynamic-row" style="align-items:center;">
              <input type="text" name="links[{{ $i }}][platform]" class="form-control" value="{{ $link->platform }}" placeholder="facebook" style="max-width:120px;">
              <input type="text" name="links[{{ $i }}][display_label]" class="form-control" value="{{ $link->display_label }}" placeholder="Facebook" style="max-width:120px;">
              <input type="url" name="links[{{ $i }}][url]" class="form-control" value="{{ $link->url }}" placeholder="https://...">
              <label style="display:flex;align-items:center;gap:.35rem;white-space:nowrap;font-size:.8rem;font-weight:400;text-transform:none;letter-spacing:0;color:#555;min-width:60px;">
                <input type="checkbox" name="links[{{ $i }}][is_active]" value="1" {{ $link->is_active ? 'checked' : '' }}> Active
              </label>
              <button type="button" class="btn-remove" onclick="this.parentNode.remove()">×</button>
            </div>
            @endforeach
          </div>
          <button type="button" class="btn-add-row" onclick="addSocial()" style="margin-bottom:1rem;">+ Add Social Link</button>
          <br>
          <button type="submit" class="btn-sm btn-primary">Save Social Links</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
let socialIdx = {{ $socialLinks->count() }};
function addSocial() {
  const d = document.createElement('div'); d.className = 'dynamic-row'; d.style.alignItems = 'center';
  d.innerHTML = `<input type="text" name="links[${socialIdx}][platform]" class="form-control" placeholder="facebook" style="max-width:120px;"><input type="text" name="links[${socialIdx}][display_label]" class="form-control" placeholder="Facebook" style="max-width:120px;"><input type="url" name="links[${socialIdx}][url]" class="form-control" placeholder="https://..."><label style="display:flex;align-items:center;gap:.35rem;white-space:nowrap;font-size:.8rem;font-weight:400;text-transform:none;letter-spacing:0;color:#555;min-width:60px;"><input type="checkbox" name="links[${socialIdx}][is_active]" value="1" checked> Active</label><button type="button" class="btn-remove" onclick="this.parentNode.remove()">×</button>`;
  document.getElementById('social-list').appendChild(d); socialIdx++;
}
</script>
@endsection
