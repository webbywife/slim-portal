<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Redirecting to LMS…</title>
  <style>
    body{font-family:sans-serif;display:flex;align-items:center;justify-content:center;
      height:100vh;background:#3d101c;color:#fff;text-align:center}
    p{opacity:.7;margin-top:.5rem;font-size:.9rem}
  </style>
</head>
<body>
  <div>
    <h2>Signing you in to the LMS…</h2>
    <p>Please wait a moment.</p>
  </div>
  <form id="sso" method="POST" action="{{ $lmsUrl }}/login/index.php" style="display:none">
    <input type="hidden" name="username" value="{{ $username }}">
    <input type="hidden" name="password" value="{{ $password }}">
    <input type="hidden" name="anchor"   value="">
    <input type="submit">
  </form>
  <script>
    // Auto-submit after a short delay
    setTimeout(function() { document.getElementById('sso').submit(); }, 600);
  </script>
</body>
</html>
