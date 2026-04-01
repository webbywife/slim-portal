@extends('layouts.admin')
@php $pageTitle = 'Page Content'; $currentPage = 'content'; @endphp

@section('content')
<div class="tabs-wrap">
  <div class="tabs">
    <button class="tab-btn" data-tab="announcement">Announcement</button>
    <button class="tab-btn" data-tab="hero">Hero</button>
    <button class="tab-btn" data-tab="hero-stats">Hero Stats</button>
    <button class="tab-btn" data-tab="about">About / Legacy</button>
    <button class="tab-btn" data-tab="alumni-chips">Alumni Chips</button>
    <button class="tab-btn" data-tab="online">Online Learning</button>
  </div>

  {{-- Announcement --}}
  <div class="tab-panel" data-tab="announcement">
    <div class="card">
      <div class="card-header"><div class="card-title">Announcement Bar</div></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.content.update', 'announcement') }}">
          @csrf
          <div class="form-group">
            <label>Content HTML</label>
            <textarea name="content_html" class="form-control" rows="4">{{ $announcement->content_html ?? '' }}</textarea>
            <div class="form-hint">You can use HTML tags: &lt;strong&gt;, &lt;a href=""&gt;, &lt;em&gt;</div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" id="is_active" name="is_active" value="1" {{ ($announcement->is_active ?? true) ? 'checked' : '' }}>
              <label for="is_active">Show announcement bar on public site</label>
            </div>
          </div>
          <button type="submit" class="btn-sm btn-primary">Save Announcement</button>
        </form>
      </div>
    </div>
  </div>

  {{-- Hero --}}
  <div class="tab-panel" data-tab="hero">
    <div class="card">
      <div class="card-header"><div class="card-title">Hero Section</div></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.content.update', 'hero') }}">
          @csrf
          <div class="form-group">
            <label>Eyebrow Text</label>
            <input type="text" name="eyebrow" class="form-control" value="{{ $hero->eyebrow ?? '' }}">
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Headline Main</label>
              <input type="text" name="headline_main" class="form-control" value="{{ $hero->headline_main ?? '' }}">
            </div>
            <div class="form-group">
              <label>Headline Emphasis (italic gold)</label>
              <input type="text" name="headline_em" class="form-control" value="{{ $hero->headline_em ?? '' }}">
            </div>
          </div>
          <div class="form-group">
            <label>Subheadline</label>
            <textarea name="subheadline" class="form-control" rows="3">{{ $hero->subheadline ?? '' }}</textarea>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>CTA Primary Text</label>
              <input type="text" name="cta_primary_text" class="form-control" value="{{ $hero->cta_primary_text ?? '' }}">
            </div>
            <div class="form-group">
              <label>CTA Primary URL</label>
              <input type="text" name="cta_primary_url" class="form-control" value="{{ $hero->cta_primary_url ?? '' }}">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>CTA Secondary Text</label>
              <input type="text" name="cta_secondary_text" class="form-control" value="{{ $hero->cta_secondary_text ?? '' }}">
            </div>
            <div class="form-group">
              <label>CTA Secondary URL</label>
              <input type="text" name="cta_secondary_url" class="form-control" value="{{ $hero->cta_secondary_url ?? '' }}">
            </div>
          </div>
          <hr class="section-divider">
          <div class="form-row-3">
            <div class="form-group">
              <label>Seal Year</label>
              <input type="text" name="seal_year" class="form-control" value="{{ $hero->seal_year ?? '' }}" placeholder="Est. 1962">
            </div>
            <div class="form-group">
              <label>Seal Name</label>
              <input type="text" name="seal_name" class="form-control" value="{{ $hero->seal_name ?? '' }}">
            </div>
            <div class="form-group">
              <label>Seal Tagline</label>
              <input type="text" name="seal_tagline" class="form-control" value="{{ $hero->seal_tagline ?? '' }}">
            </div>
          </div>
          <button type="submit" class="btn-sm btn-primary">Save Hero</button>
        </form>
      </div>
    </div>
  </div>

  {{-- Hero Stats --}}
  <div class="tab-panel" data-tab="hero-stats">
    <div class="card">
      <div class="card-header"><div class="card-title">Hero Stats Strip</div></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.content.update', 'hero-stats') }}">
          @csrf
          <p style="font-size:.82rem;color:#888;margin-bottom:1rem;">These appear in the stats strip at the bottom of the hero section.</p>
          <div id="stats-list">
            @foreach($heroStats as $i => $stat)
            <div class="dynamic-row">
              <input type="text" name="stats[{{ $i }}][stat_value]" class="form-control" value="{{ $stat->stat_value }}" placeholder="60+">
              <input type="text" name="stats[{{ $i }}][stat_label]" class="form-control" value="{{ $stat->stat_label }}" placeholder="Years of Excellence">
              <button type="button" class="btn-remove" onclick="this.parentNode.remove()">×</button>
            </div>
            @endforeach
          </div>
          <button type="button" class="btn-add-row" onclick="addStat()" style="margin-bottom:1rem;">+ Add Stat</button>
          <br>
          <button type="submit" class="btn-sm btn-primary">Save Stats</button>
        </form>
      </div>
    </div>
  </div>

  {{-- About --}}
  <div class="tab-panel" data-tab="about">
    <div class="card">
      <div class="card-header"><div class="card-title">About / Legacy Section</div></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.content.update', 'about') }}">
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label>Section Label</label>
              <input type="text" name="section_label" class="form-control" value="{{ $about->section_label ?? '' }}" placeholder="Our Heritage">
            </div>
            <div class="form-group">
              <label>Badge Number</label>
              <input type="text" name="badge_number" class="form-control" value="{{ $about->badge_number ?? '' }}" placeholder="60+">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Heading Main</label>
              <input type="text" name="heading_main" class="form-control" value="{{ $about->heading_main ?? '' }}">
            </div>
            <div class="form-group">
              <label>Heading Emphasis (italic)</label>
              <input type="text" name="heading_em" class="form-control" value="{{ $about->heading_em ?? '' }}">
            </div>
          </div>
          <div class="form-group">
            <label>Body Paragraph 1</label>
            <textarea name="body_para1" class="form-control" rows="4">{{ $about->body_para1 ?? '' }}</textarea>
          </div>
          <div class="form-group">
            <label>Body Paragraph 2</label>
            <textarea name="body_para2" class="form-control" rows="4">{{ $about->body_para2 ?? '' }}</textarea>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Quote Text</label>
              <textarea name="quote_text" class="form-control" rows="3">{{ $about->quote_text ?? '' }}</textarea>
            </div>
            <div class="form-group">
              <label>Quote Citation</label>
              <input type="text" name="quote_cite" class="form-control" value="{{ $about->quote_cite ?? '' }}">
              <div class="form-group" style="margin-top:.75rem;">
                <label>Badge Text</label>
                <input type="text" name="badge_text" class="form-control" value="{{ $about->badge_text ?? '' }}" placeholder="Years of Technical Excellence">
              </div>
            </div>
          </div>
          <button type="submit" class="btn-sm btn-primary">Save About</button>
        </form>
      </div>
    </div>
  </div>

  {{-- Alumni Chips --}}
  <div class="tab-panel" data-tab="alumni-chips">
    <div class="card">
      <div class="card-header"><div class="card-title">Alumni Category Chips</div></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.content.update', 'alumni-chips') }}">
          @csrf
          <p style="font-size:.82rem;color:#888;margin-bottom:1rem;">These are the small tag chips shown below the about section quote.</p>
          <div id="chips-list">
            @foreach($alumniChips as $i => $chip)
            <div class="dynamic-row">
              <input type="text" name="chips[{{ $i }}]" class="form-control" value="{{ $chip->label }}" placeholder="Fashion Designers">
              <button type="button" class="btn-remove" onclick="this.parentNode.remove()">×</button>
            </div>
            @endforeach
          </div>
          <button type="button" class="btn-add-row" onclick="addChip()" style="margin-bottom:1rem;">+ Add Chip</button>
          <br>
          <button type="submit" class="btn-sm btn-primary">Save Chips</button>
        </form>
      </div>
    </div>
  </div>

  {{-- Online --}}
  <div class="tab-panel" data-tab="online">
    <div class="card">
      <div class="card-header"><div class="card-title">Online Learning Section</div></div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.content.update', 'online') }}">
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label>Section Label</label>
              <input type="text" name="section_label" class="form-control" value="{{ $online->section_label ?? '' }}" placeholder="Digital Campus">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Heading Line 1</label>
              <input type="text" name="heading_line1" class="form-control" value="{{ $online->heading_line1 ?? '' }}">
            </div>
            <div class="form-group">
              <label>Heading Line 2</label>
              <input type="text" name="heading_line2" class="form-control" value="{{ $online->heading_line2 ?? '' }}">
            </div>
          </div>
          <div class="form-group">
            <label>Body Text</label>
            <textarea name="body_text" class="form-control" rows="3">{{ $online->body_text ?? '' }}</textarea>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>CTA Primary Text</label>
              <input type="text" name="cta_primary_text" class="form-control" value="{{ $online->cta_primary_text ?? '' }}">
            </div>
            <div class="form-group">
              <label>CTA Primary URL</label>
              <input type="text" name="cta_primary_url" class="form-control" value="{{ $online->cta_primary_url ?? '' }}">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>CTA Secondary Text</label>
              <input type="text" name="cta_secondary_text" class="form-control" value="{{ $online->cta_secondary_text ?? '' }}">
            </div>
            <div class="form-group">
              <label>CTA Secondary URL</label>
              <input type="text" name="cta_secondary_url" class="form-control" value="{{ $online->cta_secondary_url ?? '' }}">
            </div>
          </div>
          <hr class="section-divider">
          <div class="form-row-3">
            <div class="form-group">
              <label>Platform Name</label>
              <input type="text" name="platform_name" class="form-control" value="{{ $online->platform_name ?? '' }}" placeholder="SlimsOnline">
            </div>
            <div class="form-group">
              <label>Platform Tagline</label>
              <input type="text" name="platform_tagline" class="form-control" value="{{ $online->platform_tagline ?? '' }}" placeholder="Powered by Moodle LMS">
            </div>
            <div class="form-group">
              <label>Platform URL (display)</label>
              <input type="text" name="platform_url" class="form-control" value="{{ $online->platform_url ?? '' }}" placeholder="slimsonline.school/moodle">
            </div>
          </div>
          <hr class="section-divider">
          <label style="font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#666;margin-bottom:.75rem;display:block;">Feature List</label>
          <div id="features-list">
            @foreach($onlineFeatures as $i => $feat)
            <div class="dynamic-row">
              <input type="text" name="features[{{ $i }}][feature_title]" class="form-control" value="{{ $feat->feature_title }}" placeholder="Self-Paced">
              <input type="text" name="features[{{ $i }}][feature_sub]" class="form-control" value="{{ $feat->feature_sub }}" placeholder="Learn on your schedule">
              <button type="button" class="btn-remove" onclick="this.parentNode.remove()">×</button>
            </div>
            @endforeach
          </div>
          <button type="button" class="btn-add-row" onclick="addFeature()" style="margin-bottom:1rem;">+ Add Feature</button>
          <br>
          <button type="submit" class="btn-sm btn-primary">Save Online Section</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
let statIdx = {{ $heroStats->count() }};
let chipIdx = {{ $alumniChips->count() }};
let featIdx = {{ $onlineFeatures->count() }};

function addStat() {
  const d = document.createElement('div');
  d.className = 'dynamic-row';
  d.innerHTML = `<input type="text" name="stats[${statIdx}][stat_value]" class="form-control" placeholder="60+"><input type="text" name="stats[${statIdx}][stat_label]" class="form-control" placeholder="Years of Excellence"><button type="button" class="btn-remove" onclick="this.parentNode.remove()">×</button>`;
  document.getElementById('stats-list').appendChild(d);
  statIdx++;
}
function addChip() {
  const d = document.createElement('div');
  d.className = 'dynamic-row';
  d.innerHTML = `<input type="text" name="chips[${chipIdx}]" class="form-control" placeholder="Fashion Designers"><button type="button" class="btn-remove" onclick="this.parentNode.remove()">×</button>`;
  document.getElementById('chips-list').appendChild(d);
  chipIdx++;
}
function addFeature() {
  const d = document.createElement('div');
  d.className = 'dynamic-row';
  d.innerHTML = `<input type="text" name="features[${featIdx}][feature_title]" class="form-control" placeholder="Feature"><input type="text" name="features[${featIdx}][feature_sub]" class="form-control" placeholder="Description"><button type="button" class="btn-remove" onclick="this.parentNode.remove()">×</button>`;
  document.getElementById('features-list').appendChild(d);
  featIdx++;
}
</script>
@endsection
