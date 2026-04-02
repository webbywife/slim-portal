<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/png" href="/favicon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $page->title }} — {{ $siteName }}</title>
  @if($page->meta_description)
  <meta name="description" content="{{ $page->meta_description }}">
  @endif
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --maroon:   #8c1a37;
      --maroon-d: #550D0E;
      --gold:     #C9A84C;
      --gold-l:   #E2C47A;
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
    html { scroll-behavior: smooth; }
    body { font-family: 'Lato', sans-serif; background: var(--cream); color: var(--charcoal); }
    .container { max-width: 1140px; margin: 0 auto; padding: 0 1.5rem; }

    /* ─── Nav ───────────────────────────────────────────────── */
    #nav {
      position: sticky; top: 0; z-index: 200;
      background: rgba(255,255,255,.97);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(201,168,76,.15);
      height: var(--nav-h);
    }
    .nav-inner { display: flex; align-items: center; justify-content: space-between; height: var(--nav-h); }
    .nav-logo { display: flex; align-items: center; gap: .75rem; text-decoration: none; }
    .nav-seal svg { width: 28px; height: 28px; }
    .nav-brand-name { font-family: 'Playfair Display', serif; font-size: .95rem; font-weight: 700; color: var(--charcoal); }
    .nav-brand-tag { font-size: .6rem; letter-spacing: .15em; text-transform: uppercase; color: var(--muted); }
    .nav-back { display: flex; align-items: center; gap: .5rem; font-size: .82rem; color: var(--muted); text-decoration: none; transition: color .2s; }
    .nav-back:hover { color: var(--maroon); }
    .nav-back svg { width: 14px; height: 14px; }

    /* ─── Hero ───────────────────────────────────────────────── */
    .page-hero {
      position: relative; overflow: hidden;
      min-height: 280px; display: flex; align-items: flex-end;
      background: var(--maroon-d);
    }
    .page-hero-bg {
      position: absolute; inset: 0;
      background-size: cover; background-position: center;
    }
    .page-hero-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(to top, rgba(42,8,8,.85) 0%, rgba(42,8,8,.3) 100%);
    }
    .page-hero-content {
      position: relative; z-index: 1;
      padding: 3rem 0 2.5rem;
    }
    .page-breadcrumb {
      font-size: .72rem; letter-spacing: .15em; text-transform: uppercase;
      color: var(--gold); margin-bottom: .75rem;
    }
    .page-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.8rem, 4vw, 2.8rem);
      font-weight: 700; color: var(--white);
      line-height: 1.2;
    }
    .page-excerpt {
      margin-top: .75rem;
      font-size: 1rem; color: rgba(255,255,255,.7);
      max-width: 600px; line-height: 1.6;
    }

    /* ─── No-hero fallback ───────────────────────────────────── */
    .page-header-simple {
      padding: 3rem 0 2rem;
      border-bottom: 1px solid var(--border);
    }

    /* ─── Content ────────────────────────────────────────────── */
    .page-body { padding: 3rem 0 5rem; }
    .page-content { max-width: 760px; }
    .page-content h2 { font-family: 'Playfair Display', serif; font-size: 1.6rem; margin: 2rem 0 .75rem; color: var(--charcoal); }
    .page-content h3 { font-family: 'Playfair Display', serif; font-size: 1.25rem; margin: 1.5rem 0 .6rem; color: var(--charcoal); }
    .page-content h4 { font-size: 1rem; font-weight: 700; margin: 1.25rem 0 .5rem; }
    .page-content p { margin-bottom: 1.1rem; line-height: 1.75; color: var(--charcoal); }
    .page-content ul, .page-content ol { margin: 0 0 1.1rem 1.5rem; line-height: 1.75; }
    .page-content li { margin-bottom: .35rem; }
    .page-content a { color: var(--maroon); text-decoration: underline; }
    .page-content a:hover { color: var(--gold); }
    .page-content blockquote {
      border-left: 3px solid var(--gold); padding: .75rem 1.25rem;
      margin: 1.5rem 0; background: var(--ivory); border-radius: 0 4px 4px 0;
      font-style: italic; color: var(--muted);
    }
    .page-content img { max-width: 100%; border-radius: 4px; margin: 1rem 0; }
    .page-content hr { border: none; border-top: 1px solid var(--border); margin: 2rem 0; }

    /* ─── Footer ──────────────────────────────────────────────── */
    footer { background: var(--charcoal); color: rgba(255,255,255,.6); padding: 3rem 0 1.5rem; }
    .footer-bottom {
      border-top: 1px solid rgba(255,255,255,.08);
      padding-top: 1.25rem; margin-top: 2rem;
      display: flex; justify-content: space-between;
      font-size: .75rem; color: rgba(255,255,255,.3);
    }
    .footer-bottom a { color: rgba(255,255,255,.4); text-decoration: none; }
    .footer-bottom a:hover { color: var(--gold); }
  </style>
</head>
<body>

<nav id="nav">
  <div class="container">
    <div class="nav-inner">
      <a href="{{ url('/') }}" class="nav-logo">
        <div class="nav-seal">
          <img src="/favicon.png">
        </div>
        <div class="nav-brand">
          <div class="nav-brand-name">{{ $siteName }}</div>
          <div class="nav-brand-tag">{{ $siteTagline }}</div>
        </div>
      </a>
      <a href="{{ url('/') }}" class="nav-back">
        <svg viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 2L3 7l5 5"/><path d="M3 7h10"/></svg>
        Back to Home
      </a>
    </div>
  </div>
</nav>

@if($page->hero_image)
<section class="page-hero">
  <div class="page-hero-bg" style="background-image:url('{{ Storage::url($page->hero_image) }}');"></div>
  <div class="page-hero-overlay"></div>
  <div class="container page-hero-content">
    <p class="page-breadcrumb">{{ $siteName }}</p>
    <h1 class="page-title">{{ $page->title }}</h1>
    @if($page->excerpt)
    <p class="page-excerpt">{{ $page->excerpt }}</p>
    @endif
  </div>
</section>
@else
<div class="page-header-simple">
  <div class="container">
    <p class="page-breadcrumb" style="color:var(--gold);">{{ $siteName }}</p>
    <h1 style="font-family:'Playfair Display',serif;font-size:clamp(1.6rem,4vw,2.4rem);color:var(--charcoal);line-height:1.2;">{{ $page->title }}</h1>
    @if($page->excerpt)
    <p style="margin-top:.75rem;color:var(--muted);max-width:600px;line-height:1.6;">{{ $page->excerpt }}</p>
    @endif
  </div>
</div>
@endif

<div class="page-body">
  <div class="container">
    <div class="page-content">
      {!! $page->content !!}
    </div>
  </div>
</div>

<footer>
  <div class="container">
    <div class="footer-bottom">
      <span>{{ $footer ? $footer->copyright_text : '© ' . date('Y') . ' ' . $siteName . '. All rights reserved.' }}</span>
      <span><a href="{{ url('/') }}">← Home</a> &nbsp;&middot;&nbsp; <a href="{{ route('login') }}">Admin</a></span>
    </div>
  </div>
</footer>

</body>
</html>
