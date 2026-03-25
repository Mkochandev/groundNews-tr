<!DOCTYPE html>
<html lang="tr" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gizlilik Politikası - Eksen</title>

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
        <h1 class="text-4xl font-bold text-white mb-6">Gizlilik Politikası</h1>
        <p class="text-gray-400 mb-8">Son Güncellenme: 19 Ocak 2026</p>

        <div class="space-y-8 text-gray-300 leading-relaxed">
            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Veri Toplama</h2>
                <p class="mb-4">
                    Eksen olarak kullanıcı mahremiyetine son derece önem veriyoruz. Platformumuz şu anda tamamen
                    halka açık haber kaynaklarından veri toplamaktadır ve kullanıcılardan herhangi bir kişisel bilgi
                    toplamamaktayız.
                </p>
                <div class="bg-dark-card p-6 rounded-lg">
                    <h3 class="font-bold text-white mb-3">Topladığımız Veriler:</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>✓ Temel site kullanım istatistikleri (sayfa görüntüleme sayısı, popüler haberler vb.)</li>
                        <li>✓ Tarayıcı türü ve cihaz bilgileri (anonim)</li>
                        <li>✓ IP adresi (güvenlik amaçlı, anonim hale getirilir)</li>
                        <li>✗ E-posta adresleri</li>
                        <li>✗ Kişisel kimlik bilgileri</li>
                        <li>✗ Lokasyon verileri</li>
                    </ul>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Çerezler (Cookies)</h2>
                <p>
                    Eksen, site deneyiminizi iyileştirmek için temel çerezler kullanır. Bu çerezler yalnızca teknik
                    amaçlıdır ve hiçbir kişisel bilgi içermez. Tarayıcı ayarlarınızdan çerezleri devre dışı
                    bırakabilirsiniz,
                    ancak bu durumda bazı özellikler düzgün çalışmayabilir.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Üçüncü Taraf Hizmetler</h2>
                <p class="mb-4">
                    Eksen, aşağıdaki üçüncü taraf hizmetleri kullanmaktadır:
                </p>
                <div class="space-y-3">
                    <div class="bg-dark-card p-4 rounded-lg">
                        <h3 class="font-semibold text-white mb-1">Google Gemini AI</h3>
                        <p class="text-sm text-gray-400">
                            Haber analizi için kullanılır. Haber başlıkları ve içerikleri Google'a gönderilir,
                            ancak hiçbir kullanıcı verisi paylaşılmaz.
                        </p>
                    </div>
                    <div class="bg-dark-card p-4 rounded-lg">
                        <h3 class="font-semibold text-white mb-1">Cloudflare</h3>
                        <p class="text-sm text-gray-400">
                            Site güvenliği ve performansı için kullanılır. Anonim trafik verileri işlenir.
                        </p>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Veri Güvenliği</h2>
                <p>
                    Tüm veriler şifreli bağlantılar (HTTPS) üzerinden iletilir ve güvenli sunucularda saklanır.
                    Platformumuzda herhangi bir kullanıcı hesabı sistemi olmadığından, şifre veya ödeme bilgisi gibi
                    hassas veriler toplamıyoruz.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Çocukların Mahremiyeti</h2>
                <p>
                    Eksen, 18 yaş altındaki kullanıcılardan bilerek veri toplamaz. Platformumuz genel haber
                    okuyucularına
                    yöneliktir ve yaş doğrulaması gerektirmez.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Değişiklikler</h2>
                <p>
                    Bu gizlilik politikası zaman zaman güncellenebilir. Önemli değişiklikler olduğunda, ana sayfada
                    bir bildirim gösterilecektir. Politikanın en son güncellenme tarihi sayfa başında belirtilmiştir.
                </p>
            </section>

            <section class="bg-dark-card p-8 rounded-lg">
                <h2 class="text-2xl font-bold text-white mb-4">İletişim</h2>
                <p class="mb-4">
                    Gizlilik politikamız hakkında sorularınız varsa veya verilerinizin silinmesini talep etmek
                    isterseniz, bizimle iletişime geçebilirsiniz:
                </p>
                <p class="text-bias-right font-medium">privacy@eksen.com.tr</p>
            </section>
        </div>
    </div>

    @include('components.footer')

</body>

</html>