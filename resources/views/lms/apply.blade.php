<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/png" href="/favicon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Enroll — {{ $siteName ?? "Slim's Fashion" }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
  <style>
    :root{--maroon:#8c1a37;--gold:#C9A84C;--cream:#FAF6EF;--charcoal:#2A2020;--muted:#6B5B5B;--nav-h:72px}
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Lato',sans-serif;background:var(--cream);color:var(--charcoal)}
    #nav{position:fixed;top:0;left:0;right:0;z-index:100;height:var(--nav-h);
      background:#fff;border-bottom:1px solid rgba(201,168,76,.25);
      display:flex;align-items:center;padding:0 2rem;gap:1rem;padding-top:15px}
    .nav-seal{border-radius:50%;overflow:hidden}.nav-seal img{width:44px;height:44px;object-fit:cover}
    .nav-brand{font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--maroon);font-weight:700}
    .nav-links{margin-left:auto;display:flex;gap:1.5rem;align-items:center;font-size:.85rem;
      letter-spacing:.06em;text-transform:uppercase}
    .nav-links a{color:var(--muted);transition:color .2s}
    .nav-links a:hover,.nav-links a.active{color:var(--maroon)}
    .nav-links .btn-enroll{background:var(--maroon);color:#fff;padding:.45rem 1.1rem;border-radius:3px}

    .page-wrap{padding-top:calc(var(--nav-h) + 3rem);padding-bottom:5rem;min-height:100vh}
    .container{max-width:620px;margin:0 auto;padding:0 1.5rem}
    .form-card{background:#fff;border-radius:8px;box-shadow:0 4px 24px rgba(0,0,0,.08);padding:2.5rem}
    .form-card h1{font-family:'Playfair Display',serif;color:var(--maroon);font-size:1.8rem;margin-bottom:.5rem}
    .form-card .sub{color:var(--muted);margin-bottom:2rem;font-size:.9rem}
    .field{margin-bottom:1.25rem}
    .field label{display:block;font-size:.82rem;letter-spacing:.04em;text-transform:uppercase;
      color:var(--muted);margin-bottom:.4rem;font-weight:700}
    .field input,.field select{width:100%;padding:.65rem .9rem;border:1px solid #ddd;border-radius:4px;
      font-family:'Lato',sans-serif;font-size:.95rem;transition:border .2s;background:#fff}
    .field input:focus,.field select:focus{outline:none;border-color:var(--maroon)}
    .field-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
    .btn-submit{width:100%;background:var(--maroon);color:#fff;border:none;padding:.85rem;
      font-family:'Lato',sans-serif;font-size:1rem;font-weight:700;border-radius:4px;
      cursor:pointer;letter-spacing:.04em;text-transform:uppercase;transition:background .2s;margin-top:.5rem}
    .btn-submit:hover{background:#711c32}
    .alert-success{background:#d4edda;color:#155724;border:1px solid #c3e6cb;
      padding:1rem 1.25rem;border-radius:4px;margin-bottom:1.5rem;font-size:.9rem}
    .alert-error{background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;
      padding:1rem 1.25rem;border-radius:4px;margin-bottom:1.5rem;font-size:.9rem}
    footer{background:#1a0a0e;color:rgba(255,255,255,.5);text-align:center;padding:1.5rem;font-size:.8rem}
  </style>
</head>
<body>

<nav id="nav">
  <div class="nav-seal"><img src="/favicon.png" alt="seal"></div>
  <span class="nav-brand">Slim's Fashion</span>
  <div class="nav-links">
    <a href="/">Home</a>
    <a href="{{ route('lms.index') }}">LMS</a>
    <a href="{{ route('lms.apply') }}" class="btn-enroll active">Enroll Now</a>
  </div>
</nav>

<div class="page-wrap">
  <div class="container">

    @if(session('success'))
      <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
      <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="form-card">
      <h1>Enrollment Application</h1>
      <p class="sub">Complete the form below to apply for enrollment. We'll create your LMS account and get you started.</p>

      <form method="POST" action="{{ route('lms.apply.submit') }}">
        @csrf
        <div class="field-row">
          <div class="field">
            <label>First Name *</label>
            <input type="text" name="firstname" value="{{ old('firstname') }}" required>
          </div>
          <div class="field">
            <label>Last Name *</label>
            <input type="text" name="lastname" value="{{ old('lastname') }}" required>
          </div>
        </div>
        <div class="field">
          <label>Email Address *</label>
          <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="field">
          <label>Phone Number</label>
          <input type="tel" name="phone" value="{{ old('phone') }}">
        </div>
        <div class="field">
          <label>Course of Interest</label>
          <select name="course_id">
            <option value="">— Select a Course —</option>
            @foreach($courses as $course)
              <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                {{ $course->course_name }}
              </option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="btn-submit">Submit Application</button>
      </form>
    </div>

  </div>
</div>

<footer>&copy; {{ date('Y') }} Slim's Fashion Institute. All rights reserved.</footer>
</body>
</html>
