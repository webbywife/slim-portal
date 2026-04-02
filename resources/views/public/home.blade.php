<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/png" href="/favicon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $siteName }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,900;1,400;1,500&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet" />

  <style>
    /* ─── Design Tokens ─────────────────────────────────────── */
    :root {
      --maroon:   #8c1a37;
      --maroon-d: #550D0E;
      --maroon-l: #9E2122;
      --gold:     #C9A84C;
      --gold-l:   #E2C47A;
      --cream:    #FAF6EF;
      --ivory:    #F2EBD9;
      --charcoal: #2A2020;
      --muted:    #6B5B5B;
      --white:    #FFFFFF;
      --border:   rgba(201,168,76,.3);
      --nav-h:    72px;
      --radius:   4px;
      --ease:     cubic-bezier(.25,.46,.45,.94);
    }

    /* ─── Reset & Base ──────────────────────────────────────── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Lato', sans-serif;
      background: var(--cream);
      color: var(--charcoal);
      overflow-x: hidden;
      cursor: default;
    }
    img { display: block; max-width: 100%; }
    a  { text-decoration: none; color: inherit; }
    ul { list-style: none; }

    /* ─── Utility ────────────────────────────────────────────── */
    .container { width: min(1200px, 92%); margin-inline: auto; }
    .gold-line {
      display: block; width: 60px; height: 2px;
      background: linear-gradient(90deg, var(--gold), var(--gold-l));
      margin-block: 1rem;
    }
    .gold-line.center { margin-inline: auto; }
    .section-label {
      font-family: 'Lato', sans-serif;
      font-size: .7rem; font-weight: 700;
      letter-spacing: .25em; text-transform: uppercase;
      color: var(--gold);
    }
    .btn {
      display: inline-flex; align-items: center; gap: .5rem;
      padding: .85rem 2rem;
      font-family: 'Lato', sans-serif;
      font-size: .8rem; font-weight: 700;
      letter-spacing: .12em; text-transform: uppercase;
      border: none; cursor: pointer;
      transition: all .3s var(--ease);
    }
    .btn-primary {
      background: var(--gold);
      color: var(--maroon-d);
    }
    .btn-primary:hover {
      background: var(--gold-l);
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(201,168,76,.35);
    }
    .btn-outline {
      background: transparent;
      color: var(--white);
      border: 1.5px solid rgba(255,255,255,.6);
    }
    .btn-outline:hover {
      background: rgba(255,255,255,.12);
      border-color: var(--white);
    }
    .btn-maroon {
      background: var(--maroon);
      color: var(--white);
    }
    .btn-maroon:hover {
      background: #3d101c;
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(123,18,19,.3);
    }

    /* ─── Noise Texture Overlay ──────────────────────────────── */
    body::before {
      content: '';
      position: fixed; inset: 0; z-index: 0;
      pointer-events: none;
      opacity: .025;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
      background-size: 200px;
    }

    /* ─── Announcement Bar ───────────────────────────────────── */
    #announce {
      background: #3d101c;
      color: rgba(255,255,255,.85);
      font-size: .72rem; font-weight: 300;
      letter-spacing: .08em;
      text-align: center;
      padding: .6rem 4%;
      overflow: hidden;
    }
    #announce a { color: var(--gold-l); text-decoration: underline; text-underline-offset: 3px; }
    #announce strong { font-weight: 700; color: var(--white); }

    /* ─── Navigation ─────────────────────────────────────────── */
    #nav {
      position: sticky; top: 0; z-index: 1000;
      background: rgba(250,246,239,.97);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid var(--border);
      height: var(--nav-h);
      transition: box-shadow .3s;
    }
    #nav.scrolled { box-shadow: 0 4px 32px rgba(42,32,32,.1); }
    .nav-inner {
      height: 100%; display: flex; align-items: center;
      justify-content: space-between; gap: 1.5rem;
      min-width: 0;
    }
    .nav-logo {
      display: flex; align-items: center; gap: .9rem;
      flex-shrink: 0;
    }
    .nav-seal {
      width: 44px; height: 44px;
      border-radius: 50%;
      overflow: hidden;
      flex-shrink: 0;
    }
    .nav-seal img { width: 44px; height: 44px; object-fit: cover; display: block; }
    .nav-brand { line-height: 1.1; }
    .nav-brand-name {
      font-family: 'Playfair Display', serif;
      font-size: .95rem; font-weight: 700;
      color: var(--maroon);
      letter-spacing: .01em;
    }
    .nav-brand-tag {
      font-size: .62rem; font-weight: 300;
      letter-spacing: .18em; text-transform: uppercase;
      color: var(--muted);
    }
    .nav-menu {
      display: flex; align-items: center; gap: 0;
      height: 100%;
      flex-shrink: 1;
      min-width: 0;
    }
    .nav-item {
      position: relative; height: 100%;
      display: flex; align-items: center;
    }
    .nav-link {
      display: flex; align-items: center; gap: .3rem;
      padding: 0 .75rem;
      font-size: .68rem; font-weight: 700;
      letter-spacing: .08em; text-transform: uppercase;
      color: var(--charcoal);
      height: 100%;
      transition: color .2s;
      white-space: nowrap;
    }
    .nav-link:hover, .nav-item:hover > .nav-link { color: var(--maroon); }
    .nav-link .chevron {
      width: 8px; height: 5px;
      transition: transform .2s;
    }
    .nav-item:hover .chevron { transform: rotate(180deg); }
    .nav-link::after {
      content: ''; position: absolute; bottom: 0; left: .9rem; right: .9rem;
      height: 2px; background: var(--gold);
      transform: scaleX(0); transform-origin: left;
      transition: transform .3s var(--ease);
    }
    .nav-item:hover > .nav-link::after { transform: scaleX(1); }

    /* Dropdown */
    .dropdown {
      position: absolute; top: calc(100% + 1px); left: 0;
      background: var(--white);
      border: 1px solid var(--border);
      border-top: 2px solid var(--maroon);
      min-width: 190px;
      box-shadow: 0 16px 48px rgba(42,32,32,.12);
      opacity: 0; visibility: hidden; pointer-events: none;
      transform: translateY(-8px);
      transition: all .25s var(--ease);
      z-index: 100;
    }
    .nav-item:hover .dropdown {
      opacity: 1; visibility: visible;
      pointer-events: auto; transform: none;
    }
    .dropdown a {
      display: block; padding: .75rem 1.2rem;
      font-size: .72rem; font-weight: 400;
      letter-spacing: .06em; text-transform: uppercase;
      color: var(--charcoal);
      border-bottom: 1px solid rgba(0,0,0,.05);
      transition: all .15s;
    }
    .dropdown a:last-child { border-bottom: none; }
    .dropdown a:hover { background: var(--cream); color: var(--maroon); padding-left: 1.6rem; }

    /* Online CTA in nav */
    .nav-cta {
      margin-left: .5rem;
      padding: .55rem 1.1rem;
      font-size: .68rem; font-weight: 700;
      letter-spacing: .12em; text-transform: uppercase;
      background: var(--maroon);
      color: var(--white);
      border-radius: var(--radius);
      transition: all .2s;
      white-space: nowrap;
      height: auto;
    }
    .nav-cta:hover { background: var(--maroon-d); color: var(--white); }
    .nav-cta::after { display: none; }

    /* Hamburger */
    .nav-toggle {
      display: none; flex-direction: column; gap: 5px;
      cursor: pointer; padding: .5rem; background: none; border: none;
    }
    .nav-toggle span {
      display: block; width: 22px; height: 1.5px;
      background: var(--charcoal);
      transition: all .3s;
    }

    /* ─── HERO ───────────────────────────────────────────────── */
    #hero {
      position: relative;
      min-height: calc(100vh - var(--nav-h));
      display: flex;
      flex-direction: column;
      overflow: hidden;
      background: #3d101c;
    }
    #hero > .container {
      flex: 1;
      display: flex;
      align-items: center;
    }
    .hero-bg {
      position: absolute; inset: 0;
      background-color: #3d101c;
    }
    .hero-diagonal {
      position: absolute; right: 0; top: 0;
      width: 45%; height: 100%;
      background: rgba(255,255,255,.03);
      clip-path: polygon(12% 0, 100% 0, 100% 100%, 0% 100%);
    }
    .hero-ornament {
      position: absolute; right: 8%; top: 50%;
      transform: translateY(-50%);
      width: 340px; height: 340px;
      opacity: .12;
    }
    .hero-content {
      position: relative; z-index: 2;
      display: grid; grid-template-columns: 1fr auto;
      align-items: center; gap: 4rem;
      padding-block: 5rem;
      width: 100%;
    }
    .hero-text { max-width: 620px; }
    .hero-eyebrow {
      font-family: 'Lato', sans-serif;
      font-size: .7rem; font-weight: 700;
      letter-spacing: .3em; text-transform: uppercase;
      color: var(--gold);
      margin-bottom: 1.5rem;
      opacity: 0; animation: fadeUp .8s .2s var(--ease) forwards;
    }
    .hero-headline {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.8rem, 6vw, 5rem);
      font-weight: 900; line-height: 1.05;
      color: var(--white);
      margin-bottom: 1.5rem;
      opacity: 0; animation: fadeUp .9s .4s var(--ease) forwards;
    }
    .hero-headline em {
      font-style: italic; color: var(--gold-l);
      display: block;
    }
    .hero-sub {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.2rem; font-weight: 300; font-style: italic;
      color: rgba(255,255,255,.75);
      line-height: 1.7; max-width: 480px;
      margin-bottom: 2.5rem;
      opacity: 0; animation: fadeUp .9s .6s var(--ease) forwards;
    }
    .hero-actions {
      display: flex; flex-wrap: wrap; gap: 1rem;
      opacity: 0; animation: fadeUp .9s .8s var(--ease) forwards;
    }
    .hero-seal-wrap {
      flex-shrink: 0;
      opacity: 0; animation: fadeIn 1.2s .6s var(--ease) forwards;
    }
    .hero-seal-graphic {
      width: 220px; height: 220px;
      border-radius: 50%;
      border: 2px solid rgba(201,168,76,.4);
      background: radial-gradient(circle at 35% 35%, rgba(255,255,255,.12), transparent 60%),
                  rgba(255,255,255,.04);
      display: flex; align-items: center; justify-content: center;
      position: relative;
    }
    .hero-seal-graphic::before {
      content: '';
      position: absolute; inset: 8px;
      border-radius: 50%;
      border: 1px solid rgba(201,168,76,.25);
    }
    .hero-seal-graphic::after {
      content: '';
      position: absolute; inset: 18px;
      border-radius: 50%;
      border: 1px dashed rgba(201,168,76,.15);
    }
    .seal-inner {
      display: flex; flex-direction: column; align-items: center;
      gap: .25rem; z-index: 1;
    }
    .seal-inner .seal-year {
      font-family: 'Lato', sans-serif;
      font-size: .6rem; letter-spacing: .25em; text-transform: uppercase;
      color: var(--gold); opacity: .8;
    }
    .seal-inner .seal-name {
      font-family: 'Playfair Display', serif;
      font-size: 1.05rem; font-weight: 700; text-align: center;
      line-height: 1.2; color: var(--white);
    }
    .seal-inner .seal-tagline {
      font-family: 'Cormorant Garamond', serif;
      font-size: .75rem; font-style: italic;
      color: rgba(255,255,255,.6); letter-spacing: .05em;
    }
    /* Stats strip */
    .hero-stats {
      position: relative; z-index: 2;
      display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
      border-top: 1px solid rgba(201,168,76,.2);
      width: 100%;
      flex-shrink: 0;
      opacity: 0; animation: fadeUp .9s 1s var(--ease) forwards;
    }
    .stat-item {
      padding: 2rem;
      border-right: 1px solid rgba(201,168,76,.15);
      text-align: center;
    }
    .stat-item:last-child { border-right: none; }
    .stat-num {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem; font-weight: 700;
      color: var(--gold-l); line-height: 1;
    }
    .stat-label {
      font-size: .65rem; letter-spacing: .18em; text-transform: uppercase;
      color: rgba(255,255,255,.5); margin-top: .4rem;
    }

    /* ─── SECTION COMMON ─────────────────────────────────────── */
    section { position: relative; z-index: 1; }

    /* ─── LEGACY ─────────────────────────────────────────────── */
    #legacy {
      background: var(--cream);
      padding-block: 7rem;
    }
    .legacy-grid {
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 6rem; align-items: center;
    }
    .legacy-visual {
      position: relative;
    }
    .legacy-img-frame {
      aspect-ratio: 4/5;
      background: linear-gradient(135deg, #D4A5A5 0%, #B87878 40%, var(--maroon) 100%);
      border-radius: 2px;
      overflow: hidden;
      position: relative;
    }
    .legacy-img-frame::before {
      content: '';
      position: absolute; inset: 0;
      background:
        repeating-linear-gradient(
          45deg,
          transparent,
          transparent 8px,
          rgba(255,255,255,.05) 8px,
          rgba(255,255,255,.05) 9px
        );
    }
    .legacy-img-inner {
      position: absolute; inset: 0;
      display: flex; align-items: center; justify-content: center;
      flex-direction: column; gap: 1rem; padding: 2rem;
      text-align: center; color: rgba(255,255,255,.5);
    }
    .legacy-img-inner svg { opacity: .4; width: 60px; height: 60px; }
    .legacy-img-inner span {
      font-size: .68rem; letter-spacing: .2em; text-transform: uppercase;
    }
    .legacy-badge {
      position: absolute; bottom: -2rem; right: -2rem;
      background: var(--maroon);
      padding: 1.5rem 2rem;
      border-left: 3px solid var(--gold);
      box-shadow: 0 16px 40px rgba(42,32,32,.2);
    }
    .legacy-badge .badge-num {
      font-family: 'Playfair Display', serif;
      font-size: 3rem; font-weight: 900;
      color: var(--gold-l); line-height: 1;
    }
    .legacy-badge .badge-text {
      font-size: .65rem; letter-spacing: .18em; text-transform: uppercase;
      color: rgba(255,255,255,.7); margin-top: .3rem; line-height: 1.4;
    }
    .legacy-corner {
      position: absolute; top: -1.5rem; left: -1.5rem;
      width: 60px; height: 60px;
      border-top: 2px solid var(--gold);
      border-left: 2px solid var(--gold);
      opacity: .5;
    }

    .legacy-text .section-label { margin-bottom: .5rem; }
    .legacy-heading {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem, 3.5vw, 2.8rem);
      font-weight: 700; line-height: 1.25;
      color: var(--maroon-d);
      margin-bottom: 1.5rem;
    }
    .legacy-heading em { font-style: italic; color: var(--maroon); }
    .legacy-body {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.15rem; line-height: 1.85;
      color: var(--muted);
      margin-bottom: 1.5rem;
    }
    .legacy-quote {
      border-left: 3px solid var(--gold);
      padding-left: 1.5rem;
      margin: 2rem 0;
    }
    .legacy-quote p {
      font-family: 'Playfair Display', serif;
      font-size: 1.1rem; font-style: italic;
      color: var(--maroon); line-height: 1.6;
    }
    .legacy-quote cite {
      display: block; margin-top: .5rem;
      font-size: .68rem; letter-spacing: .12em; text-transform: uppercase;
      color: var(--muted); font-style: normal;
    }
    .alumni-chips {
      display: flex; flex-wrap: wrap; gap: .5rem;
      margin-top: 2rem;
    }
    .chip {
      padding: .4rem .9rem;
      background: var(--ivory);
      border: 1px solid var(--border);
      border-radius: 2rem;
      font-size: .7rem; letter-spacing: .06em;
      color: var(--maroon); font-weight: 700;
    }

    /* ─── ONLINE LEARNING ────────────────────────────────────── */
    #online {
      background: #3d101c;
      overflow: hidden;
      padding-block: 0;
    }
    .online-inner {
      display: grid; grid-template-columns: 1fr 1fr;
      min-height: 520px;
    }
    .online-content {
      padding: 6rem 4rem 6rem 0;
      display: flex; flex-direction: column; justify-content: center;
    }
    .online-content .section-label { color: var(--gold-l); }
    .online-heading {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.8rem, 3vw, 2.5rem);
      font-weight: 700; color: var(--white);
      line-height: 1.3; margin-bottom: 1.25rem;
    }
    .online-heading span { color: var(--gold-l); font-style: italic; }
    .online-body {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem; line-height: 1.8;
      color: rgba(255,255,255,.7); margin-bottom: 2rem;
    }
    .online-features {
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 1rem; margin-bottom: 2.5rem;
    }
    .online-feat {
      display: flex; align-items: flex-start; gap: .75rem;
    }
    .feat-icon {
      width: 32px; height: 32px; flex-shrink: 0;
      border-radius: 50%;
      background: rgba(201,168,76,.15);
      border: 1px solid rgba(201,168,76,.3);
      display: flex; align-items: center; justify-content: center;
    }
    .feat-icon svg { width: 14px; height: 14px; color: var(--gold); }
    .feat-text p {
      font-size: .72rem; font-weight: 700;
      letter-spacing: .06em; text-transform: uppercase;
      color: var(--white);
    }
    .feat-text span {
      font-size: .72rem; color: rgba(255,255,255,.5);
    }
    .online-visual {
      position: relative; overflow: hidden;
      background: linear-gradient(135deg, var(--maroon) 0%, #3A0D0E 100%);
    }
    .online-visual::before {
      content: '';
      position: absolute; inset: 0;
      background:
        repeating-linear-gradient(
          -45deg,
          transparent,
          transparent 12px,
          rgba(201,168,76,.04) 12px,
          rgba(201,168,76,.04) 13px
        );
    }
    .online-visual-inner {
      position: absolute; inset: 0;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center; gap: 1.5rem;
      padding: 3rem;
    }
    .platform-card {
      background: rgba(255,255,255,.06);
      border: 1px solid rgba(201,168,76,.2);
      border-radius: 8px; padding: 2rem;
      text-align: center; width: 100%; max-width: 260px;
      backdrop-filter: blur(8px);
    }
    .platform-logo-text {
      font-family: 'Playfair Display', serif;
      font-size: 1.8rem; font-weight: 700;
      color: var(--gold-l); letter-spacing: .02em;
    }
    .platform-logo-text span { color: rgba(255,255,255,.4); font-weight: 300; }
    .platform-desc {
      font-size: .72rem; letter-spacing: .12em; text-transform: uppercase;
      color: rgba(255,255,255,.4); margin-top: .35rem;
    }
    .platform-url {
      margin-top: 1rem; padding: .5rem .8rem;
      background: rgba(201,168,76,.15);
      border-radius: 4px;
      font-size: .68rem; font-family: 'Lato', monospace;
      color: var(--gold-l); letter-spacing: .04em;
    }

    /* ─── COURSES ────────────────────────────────────────────── */
    #courses {
      background: var(--white);
      padding-block: 7rem;
    }
    .courses-header { text-align: center; max-width: 600px; margin: 0 auto 4rem; }
    .courses-header .section-label { justify-content: center; display: flex; }
    .courses-heading {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.8rem, 3vw, 2.6rem);
      font-weight: 700; color: var(--maroon-d);
      line-height: 1.3; margin-bottom: 1rem;
    }
    .courses-sub {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem; color: var(--muted);
      line-height: 1.7;
    }
    .courses-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 1.5rem;
    }
    .course-card {
      background: var(--cream);
      border: 1px solid rgba(201,168,76,.18);
      overflow: hidden;
      transition: all .35s var(--ease);
      cursor: pointer;
    }
    .course-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 50px rgba(42,32,32,.12);
      border-color: var(--gold);
    }
    .course-img {
      height: 200px; position: relative; overflow: hidden;
    }
    .course-img-bg {
      position: absolute; inset: 0;
      transition: transform .6s var(--ease);
    }
    .course-card:hover .course-img-bg { transform: scale(1.05); }
    .course-photo { transition: transform .6s var(--ease); }
    .course-card:hover .course-photo { transform: scale(1.05); }
    .course-img-icon {
      position: absolute; inset: 0;
      display: flex; align-items: center; justify-content: center;
    }
    .course-img-icon svg {
      width: 52px; height: 52px;
      opacity: .35; color: var(--white);
      transition: transform .3s, opacity .3s;
    }
    .course-card:hover .course-img-icon svg { opacity: .6; transform: scale(1.1); }
    .course-body { padding: 1.5rem; }
    .course-cat {
      font-size: .62rem; font-weight: 700;
      letter-spacing: .2em; text-transform: uppercase;
      color: var(--gold); margin-bottom: .5rem;
    }
    .course-name {
      font-family: 'Playfair Display', serif;
      font-size: 1.15rem; font-weight: 600;
      color: var(--charcoal); line-height: 1.3;
      margin-bottom: .6rem;
    }
    .course-desc {
      font-size: .82rem; line-height: 1.65;
      color: var(--muted);
    }
    .course-footer {
      padding: 1rem 1.5rem;
      border-top: 1px solid rgba(0,0,0,.06);
      display: flex; align-items: center; justify-content: space-between;
    }
    .course-duration {
      font-size: .68rem; letter-spacing: .1em; text-transform: uppercase;
      color: var(--muted);
    }
    .course-arrow {
      width: 28px; height: 28px; border-radius: 50%;
      border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      transition: all .25s;
    }
    .course-card:hover .course-arrow {
      background: var(--maroon); border-color: var(--maroon);
      color: var(--white);
    }
    .course-arrow svg { width: 12px; height: 12px; }

    /* ─── ENROLLMENT ─────────────────────────────────────────── */
    #enrollment {
      background: var(--ivory);
      padding-block: 7rem;
    }
    .enroll-grid {
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 5rem; align-items: start;
    }
    .enroll-text .section-label { margin-bottom: .5rem; }
    .enroll-heading {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.8rem, 3vw, 2.4rem);
      font-weight: 700; color: var(--maroon-d);
      line-height: 1.3; margin-bottom: 1rem;
    }
    .enroll-body {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem; line-height: 1.8;
      color: var(--muted); margin-bottom: 2rem;
    }
    .enroll-steps { display: flex; flex-direction: column; gap: 1.25rem; }
    .enroll-step {
      display: flex; gap: 1.25rem; align-items: flex-start;
    }
    .step-num {
      width: 36px; height: 36px; flex-shrink: 0;
      border-radius: 50%;
      background: var(--maroon);
      color: var(--white);
      font-family: 'Playfair Display', serif;
      font-size: .95rem; font-weight: 700;
      display: flex; align-items: center; justify-content: center;
    }
    .step-content p {
      font-size: .88rem; font-weight: 700;
      color: var(--charcoal); margin-bottom: .2rem;
    }
    .step-content span {
      font-size: .8rem; color: var(--muted); line-height: 1.5;
    }
    .requirements-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-top: 3px solid var(--maroon);
      padding: 2.5rem;
      box-shadow: 0 8px 32px rgba(42,32,32,.06);
    }
    .req-title {
      font-family: 'Playfair Display', serif;
      font-size: 1.15rem; font-weight: 700;
      color: var(--maroon-d); margin-bottom: 1.5rem;
      display: flex; align-items: center; gap: .75rem;
    }
    .req-title::before {
      content: ''; flex-shrink: 0;
      width: 20px; height: 2px;
      background: var(--gold);
    }
    .req-list { display: flex; flex-direction: column; gap: .8rem; }
    .req-item {
      display: flex; align-items: flex-start; gap: .75rem;
      font-size: .85rem; line-height: 1.5; color: var(--charcoal);
    }
    .req-item::before {
      content: ''; flex-shrink: 0;
      width: 6px; height: 6px; border-radius: 50%;
      background: var(--gold); margin-top: .45em;
    }
    .req-note {
      margin-top: 1.5rem; padding: 1rem 1.25rem;
      background: var(--cream);
      border-left: 3px solid var(--gold);
      font-size: .78rem; color: var(--muted); line-height: 1.6;
    }
    .req-note strong { color: var(--maroon); }

    /* ─── GALLERY ────────────────────────────────────────────── */
    #gallery {
      background: var(--charcoal);
      padding-block: 7rem;
    }
    .gallery-header { text-align: center; max-width: 500px; margin: 0 auto 3rem; }
    .gallery-header .section-label { display: flex; justify-content: center; color: var(--gold-l); }
    .gallery-heading {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.8rem, 3vw, 2.4rem);
      font-weight: 700; color: var(--white);
      margin-bottom: 1rem;
    }
    .gallery-sub {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.05rem; color: rgba(255,255,255,.5); line-height: 1.7;
    }
    .gallery-masonry {
      display: grid;
      grid-template-columns: repeat(4,1fr);
      grid-auto-rows: 160px;
      gap: 8px;
    }
    .gallery-item {
      overflow: hidden; border-radius: 2px; position: relative;
      cursor: pointer;
    }
    .gallery-item.tall { grid-row: span 2; }
    .gallery-item.wide { grid-column: span 2; }
    .gallery-item-bg {
      position: absolute; inset: 0;
      transition: transform .5s var(--ease);
      background-size: cover; background-position: center;
    }
    .gallery-item:hover .gallery-item-bg { transform: scale(1.08); }
    .gallery-item-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(to top, rgba(0,0,0,.5), transparent);
      opacity: 0; transition: opacity .3s;
      display: flex; align-items: flex-end; padding: 1rem;
    }
    .gallery-item:hover .gallery-item-overlay { opacity: 1; }
    .gallery-overlay-text {
      font-size: .7rem; letter-spacing: .15em; text-transform: uppercase;
      color: rgba(255,255,255,.8);
    }

    /* Alumni strip */
    .alumni-section {
      margin-top: 4rem;
      border-top: 1px solid rgba(255,255,255,.08);
      padding-top: 4rem;
    }
    .alumni-label {
      text-align: center;
      font-size: .68rem; letter-spacing: .25em; text-transform: uppercase;
      color: rgba(255,255,255,.3); margin-bottom: 2rem;
    }
    .alumni-strip {
      display: flex; flex-wrap: wrap;
      justify-content: center; gap: 1rem;
    }
    .alumni-card {
      padding: .9rem 1.5rem;
      border: 1px solid rgba(255,255,255,.1);
      border-radius: 3px;
      text-align: center;
      transition: border-color .2s;
    }
    .alumni-card:hover { border-color: rgba(201,168,76,.4); }
    .alumni-name {
      font-family: 'Cormorant Garamond', serif;
      font-size: .95rem; font-weight: 500;
      color: rgba(255,255,255,.7);
    }
    .alumni-role {
      font-size: .62rem; letter-spacing: .12em; text-transform: uppercase;
      color: var(--gold); margin-top: .2rem; opacity: .7;
    }

    /* ─── CONTACT ────────────────────────────────────────────── */
    #contact {
      background: var(--cream);
      padding-block: 7rem;
    }
    .contact-grid {
      display: grid; grid-template-columns: 1fr 1.2fr;
      gap: 5rem; align-items: start;
    }
    .contact-info .section-label { margin-bottom: .5rem; }
    .contact-heading {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.8rem, 3vw, 2.4rem);
      font-weight: 700; color: var(--maroon-d);
      margin-bottom: 1rem; line-height: 1.3;
    }
    .contact-body {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.1rem; color: var(--muted); line-height: 1.8;
      margin-bottom: 2.5rem;
    }
    .contact-details { display: flex; flex-direction: column; gap: 1.25rem; }
    .contact-item {
      display: flex; align-items: flex-start; gap: 1rem;
    }
    .contact-icon {
      width: 40px; height: 40px; flex-shrink: 0;
      border-radius: 50%;
      background: var(--ivory); border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
    }
    .contact-icon svg { width: 16px; height: 16px; color: var(--maroon); }
    .contact-item-text p {
      font-size: .82rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .08em;
      color: var(--muted); margin-bottom: .2rem;
    }
    .contact-item-text span {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1rem; color: var(--charcoal);
    }
    /* Form */
    .contact-form { display: flex; flex-direction: column; gap: 1.25rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-group { display: flex; flex-direction: column; gap: .4rem; }
    .form-group label {
      font-size: .68rem; font-weight: 700;
      letter-spacing: .12em; text-transform: uppercase;
      color: var(--muted);
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
      padding: .85rem 1rem;
      background: var(--white);
      border: 1px solid rgba(0,0,0,.12);
      border-radius: var(--radius);
      font-family: 'Lato', sans-serif;
      font-size: .88rem; color: var(--charcoal);
      transition: border-color .2s, box-shadow .2s;
      outline: none;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      border-color: var(--maroon);
      box-shadow: 0 0 0 3px rgba(123,18,19,.08);
    }
    .form-group textarea { resize: vertical; min-height: 120px; }
    .contact-success {
      background: #f0fdf4; border: 1px solid #86efac; border-radius: 4px;
      padding: 1rem 1.25rem; margin-bottom: 1rem;
      font-size: .88rem; color: #166534;
    }

    /* ─── FOOTER ─────────────────────────────────────────────── */
    footer {
      background: #1A0A0A;
      padding-block: 4rem 2rem;
    }
    .footer-top {
      display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr;
      gap: 3rem; padding-bottom: 3rem;
      border-bottom: 1px solid rgba(255,255,255,.07);
    }
    .footer-brand .brand-name {
      font-family: 'Playfair Display', serif;
      font-size: 1.2rem; font-weight: 700;
      color: var(--white); margin-bottom: .5rem;
    }
    .footer-brand .brand-sub {
      font-size: .7rem; letter-spacing: .15em; text-transform: uppercase;
      color: rgba(255,255,255,.3); margin-bottom: 1rem;
    }
    .footer-brand p {
      font-family: 'Cormorant Garamond', serif;
      font-size: .95rem; color: rgba(255,255,255,.4);
      line-height: 1.7; max-width: 260px;
    }
    .footer-social {
      display: flex; gap: .75rem; margin-top: 1.5rem;
    }
    .social-btn {
      width: 36px; height: 36px; border-radius: 50%;
      border: 1px solid rgba(255,255,255,.15);
      display: flex; align-items: center; justify-content: center;
      color: rgba(255,255,255,.5);
      transition: all .2s;
    }
    .social-btn:hover {
      border-color: var(--gold);
      color: var(--gold);
      background: rgba(201,168,76,.08);
    }
    .social-btn svg { width: 14px; height: 14px; }
    .footer-col h4 {
      font-size: .68rem; font-weight: 700;
      letter-spacing: .2em; text-transform: uppercase;
      color: var(--gold); margin-bottom: 1.25rem;
    }
    .footer-col ul { display: flex; flex-direction: column; gap: .65rem; }
    .footer-col ul a {
      font-size: .8rem; color: rgba(255,255,255,.4);
      transition: color .2s;
    }
    .footer-col ul a:hover { color: rgba(255,255,255,.8); }
    .footer-bottom {
      display: flex; align-items: center; justify-content: space-between;
      padding-top: 2rem;
      font-size: .7rem; color: rgba(255,255,255,.25);
      letter-spacing: .06em;
    }
    .footer-bottom a { color: rgba(201,168,76,.5); }
    .footer-bottom a:hover { color: var(--gold); }

    /* ─── Animations ─────────────────────────────────────────── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: none; }
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to   { opacity: 1; }
    }
    .reveal {
      opacity: 0; transform: translateY(28px);
      transition: opacity .8s var(--ease), transform .8s var(--ease);
    }
    .reveal.visible { opacity: 1; transform: none; }
    .reveal-delay-1 { transition-delay: .1s; }
    .reveal-delay-2 { transition-delay: .2s; }
    .reveal-delay-3 { transition-delay: .3s; }
    .reveal-delay-4 { transition-delay: .4s; }

    /* ─── Responsive ─────────────────────────────────────────── */
    @media (max-width: 1024px) {
      .legacy-grid, .enroll-grid, .contact-grid { grid-template-columns: 1fr; gap: 3rem; }
      .online-inner { grid-template-columns: 1fr; }
      .online-visual { min-height: 320px; }
      .online-content { padding: 4rem 2rem; }
      .footer-top { grid-template-columns: 1fr 1fr; gap: 2rem; }
    }
    @media (max-width: 900px) {
      .nav-menu { display: none; }
      .nav-toggle { display: flex; }
    }
    @media (max-width: 768px) {
      .hero-content { grid-template-columns: 1fr; }
      .hero-seal-wrap { display: none; }
      .hero-stats { grid-template-columns: repeat(3,1fr); }
      .gallery-masonry { grid-template-columns: repeat(2,1fr); }
      .gallery-item.wide { grid-column: span 1; }
      .form-row { grid-template-columns: 1fr; }
      .footer-top { grid-template-columns: 1fr; }
      .courses-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
      .hero-stats { grid-template-columns: 1fr; }
      .stat-item { border-right: none; border-bottom: 1px solid rgba(201,168,76,.15); }
      .stat-item:last-child { border-bottom: none; }
    }

    /* Mobile nav */
    .mobile-nav {
      display: none;
      position: fixed; inset: 0; z-index: 999;
      background: var(--cream);
      flex-direction: column; padding: 2rem;
      overflow-y: auto;
    }
    .mobile-nav.open { display: flex; }
    .mobile-nav-close {
      align-self: flex-end; background: none; border: none;
      font-size: 1.5rem; cursor: pointer; margin-bottom: 2rem;
      color: var(--charcoal);
    }
    .mobile-nav-item {
      padding: 1rem 0;
      border-bottom: 1px solid var(--border);
      font-size: .9rem; font-weight: 700;
      letter-spacing: .08em; text-transform: uppercase;
      color: var(--charcoal);
    }
    .mobile-nav-item a:hover { color: var(--maroon); }
    .mobile-sub { padding-left: 1rem; margin-top: .5rem; }
    .mobile-sub a {
      display: block; padding: .4rem 0;
      font-size: .8rem; font-weight: 400; font-style: italic;
      color: var(--muted);
    }
  </style>
</head>
<body>

@if($announcement && $announcement->is_active)
<div id="announce">
  {!! $announcement->content_html !!}
</div>
@endif

<!-- Navigation -->
<nav id="nav">
  <div class="container">
    <div class="nav-inner">
      <a href="#" class="nav-logo">
        <div class="nav-seal">
          <img src="/favicon.png">
        </div>
        <div class="nav-brand">
          <div class="nav-brand-name">{{ $siteName }}</div>
          <div class="nav-brand-tag">{{ $siteTagline }}</div>
        </div>
      </a>

      <ul class="nav-menu">
        <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="#courses" class="nav-link">Courses</a></li>
        <li class="nav-item">
          <a href="#enrollment" class="nav-link">
            Enrollment
            <svg class="chevron" viewBox="0 0 10 6" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 1l4 4 4-4"/></svg>
          </a>
          <div class="dropdown">
            <a href="#enrollment">How to Enroll</a>
            <a href="#enrollment">Requirements</a>
          </div>
        </li>
        <li class="nav-item">
          <a href="#legacy" class="nav-link">
            About Us
            <svg class="chevron" viewBox="0 0 10 6" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 1l4 4 4-4"/></svg>
          </a>
          <div class="dropdown">
            <a href="#legacy">Our Founder</a>
            <a href="#legacy">Journal</a>
            <a href="#legacy">News</a>
            <a href="#gallery">Gallery</a>
            <a href="#gallery">Alumni</a>
          </div>
        </li>
        <li class="nav-item"><a href="#contact" class="nav-link">Contact Us</a></li>
        @if($online)
        <li class="nav-item">
          <a href="{{ $online->cta_primary_url }}" target="_blank" rel="noopener" class="nav-link nav-cta">
            Slims Online
          </a>
        </li>
        @endif
      </ul>

      <button class="nav-toggle" aria-label="Open menu" onclick="openMobileNav()">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</nav>

<!-- Mobile Nav -->
<div class="mobile-nav" id="mobileNav">
  <button class="mobile-nav-close" onclick="closeMobileNav()">&times;</button>
  <div class="mobile-nav-item"><a href="#">Home</a></div>
  <div class="mobile-nav-item"><a href="#courses">Courses</a></div>
  <div class="mobile-nav-item">
    <a href="#enrollment">Enrollment</a>
    <div class="mobile-sub">
      <a href="#enrollment">How to Enroll</a>
      <a href="#enrollment">Requirements</a>
    </div>
  </div>
  <div class="mobile-nav-item">
    <a href="#legacy">About Us</a>
    <div class="mobile-sub">
      <a href="#legacy">Our Founder</a>
      <a href="#legacy">Journal</a>
      <a href="#gallery">Gallery</a>
      <a href="#gallery">Alumni</a>
    </div>
  </div>
  <div class="mobile-nav-item"><a href="#contact">Contact Us</a></div>
  @if($online)
  <div class="mobile-nav-item" style="margin-top:1rem;">
    <a href="{{ $online->cta_primary_url }}" target="_blank" class="btn btn-maroon" style="width:100%;justify-content:center;">Slims Online</a>
  </div>
  @endif
</div>

<!-- HERO -->
<section id="hero">
  <div class="hero-bg" @if(!empty($hero->bg_image)) style="background-image:url('{{ Storage::url($hero->bg_image) }}');background-size:cover;background-position:center;background-blend-mode:overlay;" @endif></div>
  <div class="hero-diagonal"></div>

  <svg class="hero-ornament" viewBox="0 0 340 340" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="170" cy="170" r="168" stroke="#C9A84C" stroke-width="1"/>
    <circle cx="170" cy="170" r="148" stroke="#C9A84C" stroke-width=".5"/>
    <circle cx="170" cy="170" r="120" stroke="#C9A84C" stroke-width="1" stroke-dasharray="4 6"/>
    <path d="M170 2 L170 338 M2 170 L338 170 M50 50 L290 290 M290 50 L50 290" stroke="#C9A84C" stroke-width=".3"/>
    <polygon points="170,60 230,200 100,120 240,120 110,200" stroke="#C9A84C" stroke-width=".5" fill="none"/>
    <circle cx="170" cy="170" r="8" stroke="#C9A84C" stroke-width="1.5"/>
  </svg>

  <div class="container">
    <div class="hero-content">
      <div class="hero-text">
        @if($hero)
        <p class="hero-eyebrow">{{ $hero->eyebrow }}</p>
        <h1 class="hero-headline">
          {{ $hero->headline_main }}
          <em>{{ $hero->headline_em }}</em>
        </h1>
        <p class="hero-sub">{{ $hero->subheadline }}</p>
        <div class="hero-actions">
          <a href="{{ $hero->cta_primary_url }}" class="btn btn-primary">{{ $hero->cta_primary_text }}</a>
          <a href="{{ $hero->cta_secondary_url }}" target="_blank" rel="noopener" class="btn btn-outline">{{ $hero->cta_secondary_text }}</a>
        </div>
        @else
        <p class="hero-eyebrow">Philippines' Premier Fashion Institution</p>
        <h1 class="hero-headline">Learning<em>Without Borders</em></h1>
        <p class="hero-sub">Shaping the finest fashion minds in the Philippines for over six decades.</p>
        @endif
      </div>
      @if($hero)
      <div class="hero-seal-wrap">
        <div class="hero-seal-graphic">
          <div class="seal-inner">
            <span class="seal-year">{{ $hero->seal_year }}</span>
            <div class="seal-name">{{ $hero->seal_name }}</div>
            <span class="seal-tagline">{{ $hero->seal_tagline }}</span>
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>

  <!-- Stats Strip -->
  @if($heroStats->count())
  <div class="hero-stats">
    @foreach($heroStats as $stat)
    <div class="stat-item reveal">
      <div class="stat-num">{{ $stat->stat_value }}</div>
      <div class="stat-label">{{ $stat->stat_label }}</div>
    </div>
    @endforeach
  </div>
  @endif
</section>

<!-- LEGACY / ABOUT -->
@if($about)
<section id="legacy">
  <div class="container">
    <div class="legacy-grid">
      <div class="legacy-visual reveal">
        <div class="legacy-corner"></div>
        <div class="legacy-img-frame">
          <div class="legacy-img-inner">
            <svg viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="1">
              <path d="M32 8 C20 8 12 18 12 28 C12 42 32 56 32 56 C32 56 52 42 52 28 C52 18 44 8 32 8Z"/>
              <path d="M24 28 L32 20 L40 28 L32 36Z"/>
              <line x1="32" y1="8" x2="32" y2="56"/>
              <line x1="12" y1="28" x2="52" y2="28"/>
            </svg>
            <span>School Photo</span>
          </div>
        </div>
        <div class="legacy-badge">
          <div class="badge-num">{{ $about->badge_number }}</div>
          <div class="badge-text">{{ $about->badge_text }}</div>
        </div>
      </div>

      <div class="legacy-text">
        <p class="section-label reveal">{{ $about->section_label }}</p>
        <span class="gold-line reveal"></span>
        <h2 class="legacy-heading reveal">
          {{ $about->heading_main }}<br>
          <em>{{ $about->heading_em }}</em>
        </h2>
        <p class="legacy-body reveal">{{ $about->body_para1 }}</p>
        <p class="legacy-body reveal">{{ $about->body_para2 }}</p>

        <div class="legacy-quote reveal">
          <p>"{{ $about->quote_text }}"</p>
          <cite>— {{ $about->quote_cite }}</cite>
        </div>

        @if($alumniChips->count())
        <p class="section-label reveal" style="margin-top:2rem; margin-bottom:.75rem;">Notable Alumni</p>
        <div class="alumni-chips reveal">
          @foreach($alumniChips as $chip)
          <span class="chip">{{ $chip->label }}</span>
          @endforeach
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endif

<!-- ONLINE LEARNING -->
@if($online)
<section id="online">
  <div class="container">
    <div class="online-inner">
      <div class="online-content reveal">
        <p class="section-label">{{ $online->section_label }}</p>
        <span class="gold-line" style="background:linear-gradient(90deg,var(--gold-l),rgba(201,168,76,.3));"></span>
        <h2 class="online-heading">
          {{ $online->heading_line1 }}<br>
          <span>{{ $online->heading_line2 }}</span>
        </h2>
        <p class="online-body">{{ $online->body_text }}</p>

        @if($onlineFeatures->count())
        <div class="online-features">
          @foreach($onlineFeatures as $feat)
          <div class="online-feat">
            <div class="feat-icon">
              <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 8l3 3 7-7"/></svg>
            </div>
            <div class="feat-text">
              <p>{{ $feat->feature_title }}</p>
              <span>{{ $feat->feature_sub }}</span>
            </div>
          </div>
          @endforeach
        </div>
        @endif

        <div style="display:flex;gap:1rem;flex-wrap:wrap;">
          <a href="{{ $online->cta_primary_url }}" target="_blank" rel="noopener" class="btn btn-primary">{{ $online->cta_primary_text }}</a>
          <a href="{{ $online->cta_secondary_url }}" target="_blank" rel="noopener" class="btn btn-outline">{{ $online->cta_secondary_text }}</a>
        </div>
      </div>

      <div class="online-visual">
        <div class="online-visual-inner">
          <div class="platform-card reveal">
            <div class="platform-logo-text">{{ $online->platform_name }}<span></span></div>
            <div class="platform-desc">{{ $online->platform_tagline }}</div>
            <div class="platform-url">{{ $online->platform_url }}</div>
          </div>
          <svg width="200" height="80" viewBox="0 0 200 80" fill="none" style="opacity:.2;">
            <path d="M0 40 Q50 10 100 40 Q150 70 200 40" stroke="#C9A84C" stroke-width="1"/>
            <path d="M0 50 Q50 20 100 50 Q150 80 200 50" stroke="#C9A84C" stroke-width=".5"/>
            <path d="M0 30 Q50 0 100 30 Q150 60 200 30" stroke="#C9A84C" stroke-width=".5"/>
          </svg>
        </div>
      </div>
    </div>
  </div>
</section>
@endif

<!-- COURSES -->
<section id="courses">
  <div class="container">
    <div class="courses-header">
      <p class="section-label">Programs &amp; Courses</p>
      <span class="gold-line center"></span>
      <h2 class="courses-heading reveal">Fashion Programs for Every Aspiration</h2>
      <p class="courses-sub reveal">From foundational sewing skills to advanced fashion design, our curriculum is crafted by industry masters.</p>
    </div>

    <div class="courses-grid">
      @foreach($courses as $i => $course)
      <a href="{{ $course->slug ? route('course.show', $course->slug) : '#courses' }}" style="text-decoration:none;color:inherit;display:block;"><div class="course-card reveal {{ $i % 3 === 1 ? 'reveal-delay-1' : ($i % 3 === 2 ? 'reveal-delay-2' : '') }}">
        <div class="course-img">
          @if(!empty($course->course_image))
            <div class="course-img-bg" style="background:{{ $course->card_gradient }};"></div>
            <img src="{{ Storage::url($course->course_image) }}" alt="{{ $course->course_name }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .6s var(--ease);" class="course-photo">
          @else
            <div class="course-img-bg" style="background:{{ $course->card_gradient }};"></div>
            <div class="course-img-icon">
              <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M12 36 C12 24 24 8 24 8 C24 8 36 24 36 36"/>
                <path d="M16 28 L32 28"/><path d="M14 32 L34 32"/><path d="M18 36 L30 36"/>
              </svg>
            </div>
          @endif
        </div>
        <div class="course-body">
          <p class="course-cat">{{ $course->category_tag }}</p>
          <h3 class="course-name">{{ $course->course_name }}</h3>
          <p class="course-desc">{{ $course->description }}</p>
        </div>
        <div class="course-footer">
          <span class="course-duration">{{ $course->duration }}</span>
          <div class="course-arrow">
            <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 6h8M6 2l4 4-4 4"/></svg>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    @if($enrollment)
    <div style="text-align:center;margin-top:3rem;" class="reveal">
      <a href="{{ $enrollment->cta_url ?: '#enrollment' }}" class="btn btn-maroon">Enroll in a Course</a>
    </div>
    @endif
  </div>
</section>

<!-- ENROLLMENT -->
@if($enrollment)
<section id="enrollment">
  <div class="container">
    <div class="enroll-grid">
      <div class="enroll-text">
        <p class="section-label reveal">{{ $enrollment->section_label }}</p>
        <span class="gold-line reveal"></span>
        <h2 class="enroll-heading reveal">{{ $enrollment->heading }}</h2>
        <p class="enroll-body reveal">{{ $enrollment->body_text }}</p>

        <div class="enroll-steps">
          @foreach($steps as $step)
          <div class="enroll-step reveal reveal-delay-{{ $loop->index }}">
            <div class="step-num">{{ $loop->iteration }}</div>
            <div class="step-content">
              <p>{{ $step->step_title }}</p>
              <span>{{ $step->step_desc }}</span>
            </div>
          </div>
          @endforeach
        </div>

        @if($enrollment->cta_text)
        <div style="margin-top:2.5rem;" class="reveal">
          <a href="{{ $enrollment->cta_url }}" class="btn btn-maroon">{{ $enrollment->cta_text }}</a>
        </div>
        @endif
      </div>

      <div class="reveal reveal-delay-2">
        <div class="requirements-card">
          <h3 class="req-title">{{ $enrollment->req_card_title }}</h3>
          <div class="req-list">
            @foreach($requirements as $req)
            <div class="req-item">{{ $req->requirement }}</div>
            @endforeach
          </div>
          @if($enrollment->req_note)
          <div class="req-note">
            <strong>Note:</strong> {{ $enrollment->req_note }}
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endif

<!-- GALLERY -->
<section id="gallery">
  <div class="container">
    <div class="gallery-header">
      <p class="section-label">Campus Life &amp; Work</p>
      <span class="gold-line center" style="background:linear-gradient(90deg,var(--gold-l),rgba(201,168,76,.3));"></span>
      <h2 class="gallery-heading reveal">Gallery</h2>
      <p class="gallery-sub reveal">A glimpse into life at Slim's — our studios, workshops, fashion shows, and the faces behind the craft.</p>
    </div>

    @if($gallery->count())
    <div class="gallery-masonry reveal">
      @foreach($gallery as $item)
      <div class="gallery-item {{ $item->span_type !== 'normal' ? $item->span_type : '' }}">
        @if($item->file_path)
          <div class="gallery-item-bg" style="background:url('{{ asset('storage/' . $item->file_path) }}') center/cover no-repeat;"></div>
        @else
          <div class="gallery-item-bg" style="background:linear-gradient(135deg,#4A1A1A,#8B2222);"></div>
        @endif
        <div class="gallery-item-overlay">
          <span class="gallery-overlay-text">{{ $item->caption }}</span>
        </div>
      </div>
      @endforeach
    </div>
    @endif

    @if($alumniShowcase->count())
    <div class="alumni-section">
      <p class="alumni-label">Proud Alumni</p>
      <div class="alumni-strip">
        @foreach($alumniShowcase as $i => $a)
        <div class="alumni-card reveal reveal-delay-{{ min($i, 4) }}">
          <div class="alumni-name">{{ $a->alumni_name }}</div>
          <div class="alumni-role">{{ $a->alumni_role }}</div>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>
</section>

<!-- CONTACT -->
<section id="contact">
  <div class="container">
    <div class="contact-grid">
      <div class="contact-info">
        <p class="section-label reveal">Get in Touch</p>
        <span class="gold-line reveal"></span>
        <h2 class="contact-heading reveal">We'd Love to<br>Hear From You</h2>
        <p class="contact-body reveal">
          Whether you're a prospective student, an alumna with a question, or a partner looking to collaborate — our admissions team is ready to assist you.
        </p>

        @if($contact)
        <div class="contact-details reveal">
          @if($contact->email)
          <div class="contact-item">
            <div class="contact-icon">
              <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 4h12v9a1 1 0 01-1 1H3a1 1 0 01-1-1V4z"/><path d="M2 4l6 5 6-5"/></svg>
            </div>
            <div class="contact-item-text">
              <p>Email</p>
              <span>{{ $contact->email }}</span>
            </div>
          </div>
          @endif
          @if($contact->phone)
          <div class="contact-item">
            <div class="contact-icon">
              <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 2h3l1.5 4L6 7.5a10 10 0 004.5 4.5L12 10l4 1.5V15a1 1 0 01-1 1C6.5 16 0 9.5 0 3a1 1 0 011-1h2z"/></svg>
            </div>
            <div class="contact-item-text">
              <p>Phone</p>
              <span>{{ $contact->phone }}</span>
            </div>
          </div>
          @endif
          @if($contact->address)
          <div class="contact-item">
            <div class="contact-icon">
              <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M8 1C5.2 1 3 3.2 3 6c0 4 5 9 5 9s5-5 5-9c0-2.8-2.2-5-5-5z"/><circle cx="8" cy="6" r="1.5"/></svg>
            </div>
            <div class="contact-item-text">
              <p>Address</p>
              <span>{{ $contact->address }}</span>
            </div>
          </div>
          @endif
          @if($contact->office_hours)
          <div class="contact-item">
            <div class="contact-icon">
              <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="8" cy="8" r="6"/><path d="M8 5v3l2 2"/></svg>
            </div>
            <div class="contact-item-text">
              <p>Office Hours</p>
              <span>{{ $contact->office_hours }}</span>
            </div>
          </div>
          @endif
        </div>
        @endif
      </div>

      <div class="reveal reveal-delay-2">
        @if(session('contact_success'))
        <div class="contact-success">
          ✓ {{ session('contact_success') }}
        </div>
        @endif

        <form class="contact-form" method="POST" action="{{ route('contact.submit') }}">
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label for="first_name">First Name</label>
              <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Maria" required />
              @error('first_name')<span style="font-size:.75rem;color:#dc2626;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
              <label for="last_name">Last Name</label>
              <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Santos" required />
            </div>
          </div>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="maria@email.com" required />
          </div>
          <div class="form-group">
            <label for="inquiry_type">Inquiry Type</label>
            <select id="inquiry_type" name="inquiry_type">
              <option value="">Select an option…</option>
              <option {{ old('inquiry_type') === 'Enrollment Inquiry' ? 'selected' : '' }}>Enrollment Inquiry</option>
              <option {{ old('inquiry_type') === 'Course Information' ? 'selected' : '' }}>Course Information</option>
              <option {{ old('inquiry_type') === 'Slims Online Access' ? 'selected' : '' }}>Slims Online Access</option>
              <option {{ old('inquiry_type') === 'Alumni Inquiry' ? 'selected' : '' }}>Alumni Inquiry</option>
              <option {{ old('inquiry_type') === 'Other' ? 'selected' : '' }}>Other</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="How can we help you?">{{ old('message') }}</textarea>
          </div>
          <button type="submit" class="btn btn-maroon" style="width:100%;justify-content:center;">
            Send Message
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="footer-top">
      <div class="footer-brand">
        @if($footer)
        <div class="brand-name">{{ $footer->brand_name }}</div>
        <div class="brand-sub">{{ $footer->brand_sub }}</div>
        <p>{{ $footer->brand_blurb }}</p>
        @else
        <div class="brand-name">{{ $siteName }}</div>
        @endif
        @if($socialLinks->count())
        <div class="footer-social">
          @foreach($socialLinks as $link)
          <a href="{{ $link->url }}" target="_blank" rel="noopener" class="social-btn" aria-label="{{ $link->display_label }}">
            @if($link->platform === 'facebook')
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
            @elseif($link->platform === 'instagram')
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
            @elseif($link->platform === 'tiktok')
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.22 6.22 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.76a4.85 4.85 0 01-1.01-.07z"/></svg>
            @elseif($link->platform === 'youtube')
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.95 1.96C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 001.95-1.96A29 29 0 0023 12a29 29 0 00-.46-5.58z"/><polygon fill="#1A0A0A" points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/></svg>
            @else
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 010 20M12 2a15.3 15.3 0 000 20"/></svg>
            @endif
          </a>
          @endforeach
        </div>
        @endif
      </div>

      <div class="footer-col">
        <h4>Programs</h4>
        <ul>
          @foreach($courses->take(6) as $c)
          <li><a href="#courses">{{ $c->course_name }}</a></li>
          @endforeach
        </ul>
      </div>

      <div class="footer-col">
        <h4>School</h4>
        <ul>
          <li><a href="#legacy">About Us</a></li>
          <li><a href="#legacy">Our Founder</a></li>
          <li><a href="#gallery">Alumni</a></li>
          <li><a href="#gallery">Gallery</a></li>
          <li><a href="#enrollment">Enrollment</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h4>Online Campus</h4>
        <ul>
          @if($online)
          <li><a href="{{ $online->cta_primary_url }}" target="_blank" rel="noopener">Slims Online</a></li>
          <li><a href="{{ $online->cta_secondary_url }}" target="_blank" rel="noopener">Sign Up</a></li>
          <li><a href="#online">About the Platform</a></li>
          @endif
        </ul>
        @if($online)
        <div style="margin-top:1.5rem; padding:1rem; border:1px solid rgba(255,255,255,.08); border-radius:4px;">
          <p style="font-size:.65rem;letter-spacing:.15em;text-transform:uppercase;color:rgba(255,255,255,.3);margin-bottom:.4rem;">Online Platform</p>
          <p style="font-size:.78rem;color:rgba(255,255,255,.5);font-family:'Lato',monospace;">{{ $online->platform_url }}</p>
        </div>
        @endif
      </div>
    </div>

    <div class="footer-bottom">
      <span>{{ $footer ? $footer->copyright_text : '© ' . date('Y') . ' ' . $siteName . '. All rights reserved.' }}</span>
      <span>Built with care &nbsp;&middot;&nbsp; <a href="{{ route('login') }}">Admin</a></span>
    </div>
  </div>
</footer>

<script>
  // Nav scroll effect
  const nav = document.getElementById('nav');
  window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 40);
  });

  // Scroll reveal
  const reveals = document.querySelectorAll('.reveal');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
  reveals.forEach(el => io.observe(el));

  // Mobile nav
  function openMobileNav()  { document.getElementById('mobileNav').classList.add('open'); document.body.style.overflow='hidden'; }
  function closeMobileNav() { document.getElementById('mobileNav').classList.remove('open'); document.body.style.overflow=''; }
  document.getElementById('mobileNav').addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeMobileNav();
  });

  // Smooth close mobile nav on link click
  document.querySelectorAll('.mobile-nav a').forEach(a => {
    a.addEventListener('click', closeMobileNav);
  });
</script>
</body>
</html>
