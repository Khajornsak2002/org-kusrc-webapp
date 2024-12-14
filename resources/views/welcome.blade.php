<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>องค์กรนิสิต ศรีราชา</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                /* Custom styles for background and buttons */
                body {
                    background-image: url('https://laravel.com/assets/img/welcome/background.svg');
                    background-size: cover;
                    background-position: center;
                }
                .button {
                    background-color: #FF2D20;
                    color: white;
                    padding: 10px 20px;
                    border-radius: 5px;
                    text-decoration: none;
                    transition: background-color 0.3s;
                }
                .button:hover {
                    background-color: #e63946;
                }
                /* New styles for centering content */
                .flex {
                    display: flex;
                    justify-content: center; /* Center horizontally */
                    align-items: center; /* Center vertically */
                    height: 100vh; /* Full viewport height */
                }
            </style>
        @endif
        <link rel="icon" href="https://reg2.src.ku.ac.th/doc/images/KUSRC.png" type="image/png">
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center">
                <header class="py-10">
                    <h1 class="text-4xl font-bold text-white">ยินดีต้อนรับสู่ระบบองค์กรนิสิต</h1>
                    <br>
                </header>

                <nav class="flex flex-col gap-4">
                    <a href="{{ route('login') }}" class="button">Log in</a>
                    <a href="{{ route('register') }}" class="button">Register</a>
                </nav>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </footer>
            </div>
        </div>
    </body>
</html>
