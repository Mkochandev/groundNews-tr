<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Türkiye Haberleri - Medya Yanlılık Analizi')</title>

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="@yield('meta_description', 'Türkiye\'nin en kapsamlı haber analiz platformu. Farklı kaynaklardan haberleri karşılaştırın ve medya yanlılığını görün.')">
    <meta name="keywords" content="türkiye haberleri, medya yanlılığı, haber analizi, sol sağ merkez">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Custom Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'left-bias': '#EF4444',     // Red for left
                        'center-bias': '#9CA3AF',   // Gray for center
                        'right-bias': '#F97316',    // Orange for right
                        'dark-bg': '#0F172A',       // Dark background
                        'card-bg': '#1E293B',       // Card background
                    }
                }
            }
        }
    </script>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .bias-bar {
            height: 6px;
            border-radius: 3px;
            overflow: hidden;
        }

        .news-card {
            transition: all 0.3s ease;
        }

        .news-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .trending-scroll {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .trending-scroll::-webkit-scrollbar {
            display: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-900 antialiased">

    <!-- Header -->
    @include('components.header')

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark-bg text-gray-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-2xl font-bold text-white mb-4">Türkiye Haber Analizi</h3>
                    <p class="text-gray-400 mb-4">
                        Farklı kaynaklardan haberleri karşılaştırın, medya yanlılığını görün ve dengeli bilgi edinin.
                    </p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Keşfet</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition">Ana Sayfa</a></li>
                        <li><a href="#" class="hover:text-white transition">Gündem</a></li>
                        <li><a href="#" class="hover:text-white transition">Körnoktalar</a></li>
                        <li><a href="#" class="hover:text-white transition">Yerel Haberler</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Hakkında</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition">Metodoloji</a></li>
                        <li><a href="#" class="hover:text-white transition">İletişim</a></li>
                        <li><a href="#" class="hover:text-white transition">Gizlilik</a></li>
                        <li><a href="#" class="hover:text-white transition">Kullanım Koşulları</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-500">
                <p>&copy; 2026 Türkiye Haber Analizi. Tüm hakları saklıdır.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>