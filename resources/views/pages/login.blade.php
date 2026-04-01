<!DOCTYPE html>
<html lang="tr" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - Eksen</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: { bg: '#1a1a1a', card: '#242424', hover: '#2d2d2d' },
                        bias: { left: '#E34848', center: '#9CA3AF', right: '#3B82F6' }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #1a1a1a;
            color: #E0E0E0;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">

    @include('components.navbar')

    <div class="flex-1 flex items-center justify-center px-4 py-16">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex flex-col items-center">
                    <h1 class="text-white font-black text-4xl tracking-tighter" style="font-family: sans-serif;">EKSEN</h1>
                    <div class="w-full h-1 mt-1" style="background: linear-gradient(to right, #E34848 0%, #D3D3D3 50%, #3B82F6 100%);"></div>
                </a>
                <p class="text-gray-400 mt-4 text-sm">Hesabınıza giriş yapın</p>
            </div>

            <!-- Form Card -->
            <div class="bg-dark-card rounded-xl p-8 border border-gray-800">
                <form method="POST" action="#" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">E-posta</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            placeholder="ornek@email.com"
                            class="w-full bg-dark-bg border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-gray-500 transition"
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Şifre</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full bg-dark-bg border border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-gray-500 transition"
                        >
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 text-gray-400 cursor-pointer">
                            <input type="checkbox" class="rounded border-gray-600 bg-dark-bg">
                            Beni hatırla
                        </label>
                        <a href="#" class="text-bias-right hover:text-blue-400 transition">Şifremi unuttum</a>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-white text-dark-bg py-3 rounded-lg font-semibold hover:bg-gray-200 transition"
                    >
                        Giriş Yap
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-gray-500">
                    Hesabınız yok mu?
                    <a href="{{ route('register') }}" class="text-white hover:text-gray-300 font-medium ml-1">Kayıt Ol</a>
                </div>
            </div>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-300 text-sm transition">
                    ← Ana Sayfaya Dön
                </a>
            </div>
        </div>
    </div>

</body>

</html>
