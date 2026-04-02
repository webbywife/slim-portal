<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/png" href="/favicon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login — Slim's Fashion &amp; Arts School</title>
  <style>
    :root {
      --maroon: #8c1a37; --maroon-d: #550D0E; --maroon-db: #2E0A0B;
      --gold: #C9A84C; --gold-l: #E2C47A;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      min-height: 100vh;
      background: linear-gradient(135deg, var(--maroon-db) 0%, var(--maroon) 50%, #4A0E0E 100%);
      display: flex; align-items: center; justify-content: center;
      padding: 2rem;
    }
    .login-card {
      width: 100%; max-width: 400px;
      background: #fff; border-radius: 8px;
      padding: 2.5rem;
      box-shadow: 0 24px 64px rgba(0,0,0,.4);
    }
    .login-seal {
      display: flex; flex-direction: column; align-items: center;
      margin-bottom: 2rem; text-align: center;
    }
    .seal-icon {
      width: 64px; height: 64px; border-radius: 50%;
      overflow: hidden;
      margin-bottom: 1rem;
      box-shadow: 0 8px 24px rgba(61,16,28,.4);
    }
    .seal-icon img { width: 64px; height: 64px; object-fit: cover; display: block; }
    .login-title {
      font-size: 1.25rem; font-weight: 700; color: var(--maroon-d);
      margin-bottom: .25rem;
    }
    .login-sub {
      font-size: .75rem; letter-spacing: .12em; text-transform: uppercase;
      color: #888;
    }
    .gold-line {
      width: 40px; height: 2px;
      background: linear-gradient(90deg, var(--gold), var(--gold-l));
      margin: .75rem auto;
    }
    .form-group { margin-bottom: 1.1rem; }
    .form-group label {
      display: block; margin-bottom: .35rem;
      font-size: .7rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
      color: #666;
    }
    .form-control {
      width: 100%; padding: .7rem 1rem;
      border: 1px solid #ddd; border-radius: 4px;
      font-size: .9rem; color: #2A2020;
      outline: none; transition: border-color .15s, box-shadow .15s;
    }
    .form-control:focus { border-color: var(--maroon); box-shadow: 0 0 0 3px rgba(123,18,19,.08); }
    .form-check { display: flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem; }
    .form-check input { accent-color: var(--maroon); }
    .form-check label { font-size: .82rem; color: #555; }
    .btn-login {
      width: 100%; padding: .85rem;
      background: var(--maroon); color: #fff;
      font-size: .82rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
      border: none; border-radius: 4px; cursor: pointer;
      transition: background .15s, transform .15s;
    }
    .btn-login:hover { background: var(--maroon-d); transform: translateY(-1px); }
    .error-msg {
      background: #fef2f2; border: 1px solid #fca5a5; border-radius: 4px;
      padding: .75rem 1rem; margin-bottom: 1.1rem;
      font-size: .82rem; color: #991b1b;
    }
    .back-link {
      display: block; text-align: center; margin-top: 1rem;
      font-size: .75rem; color: #aaa; text-decoration: none;
    }
    .back-link:hover { color: var(--maroon); }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="login-seal">
      <div class="seal-icon">
        <img src="/favicon.png">
      </div>
      <div class="login-title">Slim's CMS</div>
      <div class="login-sub">Fashion &amp; Arts School</div>
      <div class="gold-line"></div>
    </div>

    @if($errors->any())
      <div class="error-msg">{{ $errors->first() }}</div>
    @endif

    @if(session('error'))
      <div class="error-msg">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
      @csrf
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required />
      </div>
      <div class="form-check">
        <input type="checkbox" id="remember" name="remember" value="1" />
        <label for="remember">Keep me signed in</label>
      </div>
      <button type="submit" class="btn-login">Sign In</button>
    </form>

    <a href="{{ route('home') }}" class="back-link">← Back to Website</a>
  </div>
</body>
</html>
