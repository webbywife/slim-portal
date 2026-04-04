@php
  use Illuminate\Support\Facades\Storage;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/png" href="/favicon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LMS — {{ $siteName ?? "Slim's Fashion" }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --maroon:#8c1a37; --gold:#C9A84C; --cream:#FAF6EF;
      --charcoal:#2A2020; --muted:#6B5B5B; --white:#fff;
      --nav-h:72px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Lato',sans-serif;background:var(--cream);color:var(--charcoal)}
    a{color:inherit;text-decoration:none}

    /* ── Nav (same as home) ── */
    #nav{position:fixed;top:0;left:0;right:0;z-index:100;height:var(--nav-h);
      background:#fff;border-bottom:1px solid rgba(201,168,76,.25);
      display:flex;align-items:center;padding:0 2rem;gap:1rem;padding-top:15px}
    .nav-seal{border-radius:50%;overflow:hidden;display:flex;align-items:center}
    .nav-seal img{width:44px;height:44px;object-fit:cover}
    .nav-brand{font-family:'Playfair Display',serif;font-size:1.1rem;letter-spacing:.04em;
      color:var(--maroon);font-weight:700}
    .nav-links{margin-left:auto;display:flex;gap:1.5rem;align-items:center;font-size:.85rem;
      letter-spacing:.06em;text-transform:uppercase}
    .nav-links a{color:var(--muted);transition:color .2s}
    .nav-links a:hover,.nav-links a.active{color:var(--maroon)}
    .nav-links .btn-enroll{background:var(--maroon);color:#fff;padding:.45rem 1.1rem;
      border-radius:3px;transition:background .2s}
    .nav-links .btn-enroll:hover{background:#711c32}

    /* ── Hero ── */
    .lms-hero{padding-top:calc(var(--nav-h) + 60px);padding-bottom:60px;
      background:linear-gradient(135deg,#3d101c 0%,#711c32 100%);
      color:#fff;text-align:center}
    .lms-hero h1{font-family:'Playfair Display',serif;font-size:clamp(2rem,4vw,3.2rem);margin-bottom:.75rem}
    .lms-hero p{opacity:.8;font-size:1.05rem;max-width:550px;margin:0 auto 2rem}
    .btn-primary{display:inline-block;background:var(--gold);color:var(--charcoal);
      font-weight:700;padding:.75rem 2rem;border-radius:3px;transition:opacity .2s;
      font-size:.9rem;letter-spacing:.04em;text-transform:uppercase}
    .btn-primary:hover{opacity:.85}

    /* ── Courses Grid ── */
    .section{padding:5rem 2rem}
    .container{max-width:1100px;margin:0 auto}
    .section-head{text-align:center;margin-bottom:3rem}
    .section-head h2{font-family:'Playfair Display',serif;font-size:2rem;color:var(--maroon)}
    .section-head p{color:var(--muted);margin-top:.5rem}
    .courses-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem}
    .course-card{background:#fff;border-radius:6px;overflow:hidden;
      box-shadow:0 2px 12px rgba(0,0,0,.07);transition:transform .2s,box-shadow .2s}
    .course-card:hover{transform:translateY(-4px);box-shadow:0 8px 24px rgba(0,0,0,.12)}
    .card-top{height:120px;background:var(--maroon);display:flex;align-items:center;
      justify-content:center;font-size:2.5rem}
    .card-body{padding:1.25rem}
    .card-body h3{font-family:'Playfair Display',serif;font-size:1.1rem;margin-bottom:.5rem}
    .card-body p{font-size:.85rem;color:var(--muted);line-height:1.6}
    .card-body .card-meta{display:flex;gap:.75rem;margin-top:.75rem;font-size:.78rem;color:var(--muted)}
    .no-courses{text-align:center;color:var(--muted);padding:3rem 0}

    /* ── Enroll CTA ── */
    .enroll-cta{background:var(--maroon);color:#fff;text-align:center;padding:4rem 2rem}
    .enroll-cta h2{font-family:'Playfair Display',serif;font-size:1.8rem;margin-bottom:.75rem}
    .enroll-cta p{opacity:.8;margin-bottom:1.5rem}
    .btn-outline{display:inline-block;border:2px solid var(--gold);color:var(--gold);
      padding:.65rem 1.75rem;border-radius:3px;font-size:.9rem;letter-spacing:.04em;
      text-transform:uppercase;font-weight:700;transition:all .2s}
    .btn-outline:hover{background:var(--gold);color:var(--charcoal)}

    /* ── Footer ── */
    footer{background:#1a0a0e;color:rgba(255,255,255,.5);text-align:center;padding:2rem;font-size:.8rem}
  </style>
</head>
<body>

<nav id="nav">
  <div class="nav-seal"><img src="/favicon.png" alt="seal"></div>
  <span class="nav-brand">Slim's Fashion</span>
  <div class="nav-links">
    <a href="/">Home</a>
    <a href="/#courses">Courses</a>
    <a href="{{ route('lms.index') }}" class="active">LMS</a>
    <a href="{{ route('lms.apply') }}" class="btn-enroll">Enroll Now</a>
  </div>
</nav>

<section class="lms-hero">
  <h1>Learning Management System</h1>
  <p>Access your fashion design courses, track progress, and connect with your instructors online.</p>
  <a href="https://lms.slimsfashion.webprvw.xyz" target="_blank" class="btn-primary">Launch LMS Portal</a>
</section>

<section class="section">
  <div class="container">
    <div class="section-head">
      <h2>Available Online Courses</h2>
      <p>Browse our current Moodle courses — enroll to gain access.</p>
    </div>

    @if($courses->count())
      <div class="courses-grid">
        @foreach($courses as $course)
          <div class="course-card">
            <div class="card-top">🎓</div>
            <div class="card-body">
              <h3>{{ $course['fullname'] ?? $course['shortname'] }}</h3>
              @if(!empty($course['summary']))
                <p>{{ strip_tags(html_entity_decode($course['summary'])) }}</p>
              @endif
              <div class="card-meta">
                @if(!empty($course['categoryname']))<span>{{ $course['categoryname'] }}</span>@endif
                @if(!empty($course['numsections']))<span>{{ $course['numsections'] }} sections</span>@endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="no-courses">
        <p>No online courses are currently available. Check back soon!</p>
      </div>
    @endif
  </div>
</section>

<section class="enroll-cta">
  <h2>Ready to Start Learning?</h2>
  <p>Submit your enrollment application and get access to our online courses.</p>
  <a href="{{ route('lms.apply') }}" class="btn-outline">Apply for Enrollment</a>
</section>

<footer>
  &copy; {{ date('Y') }} Slim's Fashion Institute. All rights reserved.
</footer>

</body>
</html>
