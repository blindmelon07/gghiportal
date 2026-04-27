<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login — GSAC General Hospital</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-brand-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="/images/gghi-logo.png" alt="GSAC General Hospital Inc." class="h-16 w-auto mx-auto mb-4">
            <p class="text-blue-300 text-sm font-medium tracking-widest uppercase">Admin Portal</p>
        </div>
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
