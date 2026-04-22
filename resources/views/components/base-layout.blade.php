<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f5f5f7;
            color: #1d1d1f;
        }

        /* ───────── NAV ───────── */
        nav {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e6e6e6;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-weight: 800;
            text-decoration: none;
            color: #1d1d1f;
        }

        .logo span {
            color: #026cdf;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #6e6e73;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .nav-links a:hover {
            color: #026cdf;
        }

        .cta {
            background: #026cdf;
            color: white !important;
            padding: 0.4rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }

        /* ───────── MAIN ───────── */
        main {
            max-width: 1150px;
            margin: 0 auto;
            padding: 3rem 1.5rem;
        }

        /* ───────── GRID ───────── */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        /* ───────── CARD ───────── */
        .card {
            background: white;
            border: 1px solid #e6e6e6;
            border-radius: 16px;
            padding: 1.3rem;
            text-decoration: none;
            color: inherit;
            display: block;
            position: relative;
            transition: all 0.25s ease;
            overflow: hidden;
        }

        .card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(2,108,223,0.08), transparent 60%);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0,0,0,0.10);
            border-color: rgba(2,108,223,0.3);
        }

        .card:hover::before {
            opacity: 1;
        }

        .title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .meta {
            color: #6e6e73;
            font-size: 0.9rem;
        }

        .badge {
            display: inline-block;
            margin-top: 1rem;
            background: #026cdf;
            color: white;
            padding: 0.35rem 0.7rem;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* ───────── FOOTER ───────── */
        footer {
            background: white;
            border-top: 1px solid #e6e6e6;
            padding: 2rem;
            font-size: 0.85rem;
            color: #6e6e73;
            text-align: center;
            margin-top: 3rem;
        }
    </style>
</head>

<body>

{{-- NAV --}}
<nav>
    <a href="{{ route('events.index') }}" class="logo">
        ◈ <span>Event</span>ify
    </a>

    <ul class="nav-links">

        <li><a href="{{ route('events.index') }}">Events</a></li>

        <li><a href="{{ route('venues.index') }}">Venues</a></li>

        @auth
            <li>
                <a href="{{ route('events.create') }}" class="cta">+ Event</a>
            </li>

            <li>
                <a href="{{ route('venues.create') }}" class="cta">+ Venue</a>
            </li>

            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="cta">Logout</button>
                </form>
            </li>
        @else
            <li>
                <a href="{{ route('login') }}" class="cta">Login</a>
            </li>

            <li>
                <a href="{{ route('register') }}" class="cta">Register</a>
            </li>
        @endauth

    </ul>
</nav>

{{-- MAIN --}}
<main>
    {{ $slot }}
</main>

{{-- FOOTER --}}
<footer>
    © {{ date('Y') }} Eventify — Premium event platform
</footer>

</body>
</html>