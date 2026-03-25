<!DOCTYPE html>
<html lang="tr" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İletişim - Eksen</title>

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

<body>
    <!-- Navbar -->
    <nav class="bg-dark-card border-b border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex flex-col items-start">
                    <h1 class="text-white font-black text-2xl tracking-tighter" style="font-family: sans-serif;">EKSEN
                    </h1>
                    <div class="w-full h-1"
                        style="background: linear-gradient(to right, #E34848 0%, #D3D3D3 50%, #3B82F6 100%);"></div>
                </a>
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm">Ana Sayfa</a>
                    <button
                        class="text-white border border-gray-700 px-6 py-2 rounded font-semibold text-sm">Giriş</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-white mb-6">İletişim</h1>
        <p class="text-gray-400 mb-12">
            Sorularınız, önerileriniz veya geri bildirimleriniz için bizimle iletişime geçebilirsiniz.
        </p>

        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Contact Cards -->
            <div class="bg-dark-card p-6 rounded-lg border-l-4 border-bias-right">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl">📧</span>
                    <h2 class="text-xl font-bold text-white">E-posta</h2>
                </div>
                <p class="text-gray-400 text-sm mb-3">Genel sorular ve geri bildirim için</p>
                <a href="mailto:info@eksen.com.tr" class="text-bias-right hover:underline font-medium">
                    info@eksen.com.tr
                </a>
            </div>

            <div class="bg-dark-card p-6 rounded-lg border-l-4 border-bias-left">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl">🔒</span>
                    <h2 class="text-xl font-bold text-white">Gizlilik</h2>
                </div>
                <p class="text-gray-400 text-sm mb-3">Veri gizliliği ve güvenlik konuları için</p>
                <a href="mailto:privacy@eksen.com.tr" class="text-bias-left hover:underline font-medium">
                    privacy@eksen.com.tr
                </a>
            </div>

            <div class="bg-dark-card p-6 rounded-lg border-l-4 border-bias-center">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl">🐛</span>
                    <h2 class="text-xl font-bold text-white">Teknik Destek</h2>
                </div>
                <p class="text-gray-400 text-sm mb-3">Hata raporları ve teknik sorunlar için</p>
                <a href="mailto:support@eksen.com.tr" class="text-bias-center hover:underline font-medium">
                    support@eksen.com.tr
                </a>
            </div>

            <div class="bg-dark-card p-6 rounded-lg border-l-4 border-green-500">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl">🤝</span>
                    <h2 class="text-xl font-bold text-white">İş Birliği</h2>
                </div>
                <p class="text-gray-400 text-sm mb-3">Ortaklık ve işbirliği teklifleri için</p>
                <a href="mailto:partnership@eksen.com.tr" class="text-green-500 hover:underline font-medium">
                    partnership@eksen.com.tr
                </a>
            </div>
        </div>

        <!-- Social Media -->
        <div class="bg-gradient-to-r from-bias-left/10 via-bias-center/10 to-bias-right/10 p-8 rounded-lg mb-8">
            <h2 class="text-2xl font-bold text-white mb-6 text-center">Sosyal Medya</h2>
            <div class="flex justify-center gap-6">
                <a href="#" class="bg-dark-card p-4 rounded-lg hover:bg-dark-hover transition">
                    <span class="text-2xl">🐦</span>
                    <p class="text-sm text-gray-400 mt-2">Twitter</p>
                </a>
                <a href="#" class="bg-dark-card p-4 rounded-lg hover:bg-dark-hover transition">
                    <span class="text-2xl">💼</span>
                    <p class="text-sm text-gray-400 mt-2">LinkedIn</p>
                </a>
                <a href="#" class="bg-dark-card p-4 rounded-lg hover:bg-dark-hover transition">
                    <span class="text-2xl">💻</span>
                    <p class="text-sm text-gray-400 mt-2">GitHub</p>
                </a>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="space-y-4">
            <h2 class="text-2xl font-bold text-white mb-6">Sıkça Sorulan Sorular</h2>

            <div class="bg-dark-card p-6 rounded-lg">
                <h3 class="font-bold text-white mb-2">Eksen nasıl para kazanıyor?</h3>
                <p class="text-gray-400 text-sm">
                    Şu anda Eksen tamamen ücretsiz bir hizmettir. Gelecekte premium özellikler veya kurumsal abonelikler
                    sunabiliriz, ancak temel haber okuma her zaman ücretsiz kalacaktır.
                </p>
            </div>

            <div class="bg-dark-card p-6 rounded-lg">
                <h3 class="font-bold text-white mb-2">Yeni bir haber kaynağı eklenebilir mi?</h3>
                <p class="text-gray-400 text-sm">
                    Kaynak önerilerinizi info@eksen.com.tr adresine gönderebilirsiniz. Her öneriyi değerlendiriyor ve
                    siyasi spektrum dengesini koruyacak şekilde yeni kaynaklar ekliyoruz.
                </p>
            </div>

            <div class="bg-dark-card p-6 rounded-lg">
                <h3 class="font-bold text-white mb-2">Bias skorları nasıl belirleniyor?</h3>
                <p class="text-gray-400 text-sm">
                    Detaylı metodolojimizi <a href="{{ route('methodology') }}"
                        class="text-bias-right hover:underline">Metodoloji</a>
                    sayfasında okuyabilirsiniz. Kısaca: kaynakların editoryal çizgisi, sahiplik yapısı ve içerik analizi
                    dikkate alınarak belirlenir.
                </p>
            </div>
        </div>
    </div>

    @include('components.footer')

</body>

</html>