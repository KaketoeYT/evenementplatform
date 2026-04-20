<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f5f5f7;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #262626;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav {
            background: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        main {
            flex: 1;
            padding: 2rem 1.5rem;
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
        }

        footer {
            background: #ffffff;
            border-top: 1px solid #e0e0e0;
            padding: 2rem;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>

    <nav>
        {{-- navbar hier --}}
    </nav>

    <main>
        {{ $slot }}
    </main>

    <footer>
        {{-- footer --}}
    </footer>

</body>
</html>