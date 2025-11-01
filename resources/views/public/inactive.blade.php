<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wartungsarbeiten</title>
    @vite(['resources/css/app.css'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-950 text-white flex items-center justify-center h-screen">
    <div class="text-center p-8 bg-gray-800 rounded-lg shadow-2xl max-w-lg mx-4">
        {{-- Nutzt die definierte Farbe text-crown-gold, falls vorhanden, sonst amber-500 --}}
        <h1 class="text-3xl font-bold mb-4 text-amber-500">{{ $restaurantName ?? 'Restaurant' }}</h1>
        <p class="text-gray-400">Diese Speisekarte ist zurzeit nicht verfügbar oder befindet sich noch im Aufbau. Bitte schauen Sie später noch einmal vorbei.</p>
        <p class="text-xs text-gray-600 mt-6">Powered by TAGS.MENU</p>
    </div>
</body>
</html>