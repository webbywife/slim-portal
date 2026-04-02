<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/png" href="/favicon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $course->course_name }} — {{ $siteName }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --maroon:   #8c1a37;
      --maroon-d: #550D0E;
      --gold:     #C9A84C;
      --cream:    #FAF6EF;
      --ivory:    #F2EBD9;
      --charcoal: #2A2020;
      --muted:    #6B5B5B;
      --white:    #FFFFFF;
      --border:   rgba(201,168,76,.3);
      --nav-h:    72px;
      --ease:     cubic-bezier(.25,.46,.45,.94);
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Lato', sans-serif; background: var(--cream); color: var(--charcoal); }
    .container { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; }

    /* Nav */
    #nav { position:sticky;top:0;z-index:200;background:rgba(255,255,255,.97);backdrop-filter:blur(12px);border-bottom:1px solid rgba(201,168,76,.15);height:var(--nav-h); }
    .nav-inner { display:flex;align-items:center;justify-content:space-between;height:var(--nav-h); }
    .nav-logo { display:flex;align-items:center;gap:.75rem;text-decoration:none; }
    .nav-brand-name { font-family:'Playfair Display',serif;font-size:.95rem;font-weight:700;color:var(--charcoal); }
    .nav-brand-tag { font-size:.6rem;letter-spacing:.15em;text-transform:uppercase;color:var(--muted); }
    .nav-back { display:flex;align-items:center;gap:.4rem;font-size:.82rem;color:var(--muted);text-decoration:none;transition:color .2s; }
    .nav-back:hover { color:var(--maroon); }

    /* Hero */
    .course-hero {
      position:relative;min-height:320px;display:flex;align-items:flex-end;
      background:var(--charcoal);overflow:hidden;
    }
    .course-hero-bg { position:absolute;inset:0;background-size:cover;background-position:center; }
    .course-hero-overlay { position:absolute;inset:0;background:linear-gradient(to top,rgba(20,5,5,.88) 0%,rgba(20,5,5,.35) 100%); }
    .course-hero-content { position:relative;z-index:1;padding:3rem 0 2.5rem; }
    .course-cat-tag { font-size:.68rem;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);margin-bottom:.6rem; }
    .course-hero-title { font-family:'Playfair Display',serif;font-size:clamp(2rem,5vw,3.2rem);font-weight:700;color:var(--white);line-height:1.15; }
    .course-hero-desc { margin-top:.9rem;font-size:1rem;color:rgba(255,255,255,.72);max-width:640px;line-height:1.7; }

    /* No-image fallback */
    .course-header-simple { padding:3rem 0 2rem;border-bottom:2px solid var(--gold); }

    /* Modules grid */
    .modules-section { padding:4rem 0 5rem; }
    .modules-section-title { font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:600;color:var(--charcoal);margin-bottom:2.5rem;padding-bottom:.75rem;border-bottom:1px solid var(--border); }
    .modules-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:1.75rem; }
    .module-card { background:var(--white);border:1px solid rgba(201,168,76,.2);border-radius:4px;padding:1.75rem;transition:box-shadow .25s; }
    .module-card:hover { box-shadow:0 8px 32px rgba(42,32,32,.09); }
    .module-title { font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:600;color:var(--maroon);line-height:1.3;margin-bottom:.5rem; }
    .module-prereq { font-size:.75rem;letter-spacing:.05em;color:var(--muted);margin-bottom:.9rem;font-style:italic; }
    .module-desc { font-size:.85rem;line-height:1.7;color:var(--charcoal);margin-bottom:1.1rem; }
    .module-fees { font-size:.82rem;color:var(--muted);line-height:1.8; }
    .module-fees strong { color:var(--charcoal); }

    /* Sub-modules */
    .submodules { margin-top:1.1rem;padding-top:1rem;border-top:1px solid #f0ebe4; }
    .submodules-label { font-size:.65rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:#bbb;margin-bottom:.6rem; }
    .submodule-item { margin-bottom:.6rem; }
    .submodule-item-title { font-size:.82rem;font-weight:700;color:var(--charcoal); }
    .submodule-item-desc { font-size:.8rem;color:var(--muted);line-height:1.5;margin-top:.15rem; }

    /* Footer */
    footer { background:var(--charcoal);color:rgba(255,255,255,.5);padding:2.5rem 0 1.5rem; }
    .footer-bottom { border-top:1px solid rgba(255,255,255,.08);padding-top:1.25rem;margin-top:1.5rem;display:flex;justify-content:space-between;font-size:.75rem;color:rgba(255,255,255,.3); }
    .footer-bottom a { color:rgba(255,255,255,.4);text-decoration:none; }
    .footer-bottom a:hover { color:var(--gold); }

    @media(max-width:640px) { .modules-grid { grid-template-columns:1fr; } }
  </style>
</head>
<body>

<nav id="nav">
  <div class="container">
    <div class="nav-inner">
      <a href="{{ url('/') }}" class="nav-logo">
        <div style="width:28px;height:28px;">
          <img src="/favicon.png">
        </div>
        <div>
          <div class="nav-brand-name">{{ $siteName }}</div>
          <div class="nav-brand-tag">{{ $siteTagline }}</div>
        </div>
      </a>
      <a href="{{ url('/') }}#courses" class="nav-back">
        <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" style="width:14px;height:14px;"><path d="M8 2L3 7l5 5"/><path d="M3 7h10"/></svg>
        All Courses
      </a>
    </div>
  </div>
</nav>

@if($course->course_image)
<section class="course-hero">
  <div class="course-hero-bg" style="background-image:url('{{ Storage::url($course->course_image) }}');"></div>
  <div class="course-hero-overlay"></div>
  <div class="container course-hero-content">
    @if($course->category_tag)<p class="course-cat-tag">{{ $course->category_tag }}</p>@endif
    <h1 class="course-hero-title">{{ $course->course_name }}</h1>
    <p class="course-hero-desc">{{ $course->description }}</p>
  </div>
</section>
@else
<div class="course-header-simple" style="background:var(--maroon-d);">
  <div class="container">
    @if($course->category_tag)<p class="course-cat-tag" style="color:var(--gold);">{{ $course->category_tag }}</p>@endif
    <h1 style="font-family:'Playfair Display',serif;font-size:clamp(1.8rem,4vw,3rem);color:var(--white);line-height:1.2;">{{ $course->course_name }}</h1>
    <p style="margin-top:.9rem;color:rgba(255,255,255,.7);max-width:640px;line-height:1.7;font-size:1rem;">{{ $course->description }}</p>
  </div>
</div>
@endif

<div class="modules-section">
  <div class="container">
    @if($course->modules->count())
    <h2 class="modules-section-title">Course Modules</h2>
    <div class="modules-grid">
      @foreach($course->modules as $module)
      <div class="module-card">
        <div class="module-title">
          {{ $module->title }}@if($module->sessions) <span style="font-size:.8rem;font-weight:400;color:var(--muted);">({{ $module->sessions }} sessions)</span>@endif
        </div>
        @if($module->prerequisite)
        <div class="module-prereq">{{ $module->prerequisite }}</div>
        @endif
        @if($module->description)
        <div class="module-desc">{{ $module->description }}</div>
        @endif
        @if($module->tuition_fee || $module->materials_fee)
        <div class="module-fees">
          @if($module->tuition_fee)<div>Tuition Fee: <strong>{{ $module->tuition_fee }}</strong></div>@endif
          @if($module->materials_fee)<div>Materials: <strong>{{ $module->materials_fee }}</strong></div>@endif
        </div>
        @endif
        @if($module->submodules->count())
        <div class="submodules">
          <div class="submodules-label">Sub-modules</div>
          @foreach($module->submodules as $sub)
          <div class="submodule-item">
            <div class="submodule-item-title">{{ $sub->title }}</div>
            @if($sub->description)<div class="submodule-item-desc">{{ $sub->description }}</div>@endif
          </div>
          @endforeach
        </div>
        @endif
      </div>
      @endforeach
    </div>
    @else
    <p style="color:var(--muted);font-style:italic;">Module details coming soon.</p>
    @endif
  </div>
</div>

<footer>
  <div class="container">
    <div class="footer-bottom">
      <span>{{ $footer ? $footer->copyright_text : '© ' . date('Y') . ' ' . $siteName }}</span>
      <span><a href="{{ url('/') }}">← Home</a></span>
    </div>
  </div>
</footer>

</body>
</html>
