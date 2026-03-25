<!DOCTYPE html>
<html lang="tr" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hakkımızda - Eksen</title>

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
        <h1 class="text-4xl font-bold text-white mb-6">Hakkımızda</h1>

        <div class="space-y-8 text-gray-300 leading-relaxed">
            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Eksen Nedir?</h2>
                <p>
                    Eksen, Türkiye'nin ilk perspektif tabanlı haber platformudur. Farklı siyasi görüşlerdeki haber
                    kaynaklarını
                    bir araya getirerek, aynı olayın nasıl farklı şekillerde aktarıldığını görmenizi sağlar.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Misyonumuz</h2>
                <p class="mb-4">
                    Modern medya ortamında, insanlar genellikle kendi görüşlerine uygun haber kaynaklarını takip eder.
                    Bu durum "medya balonu" veya "yankı odası" etkisi yaratır. Eksen, bu sorunu çözmek için tasarlandı.
                </p>
                <p>
                    Amacımız, kullanıcılara dengeli bir haber deneyimi sunarak, olayları farklı perspektiflerden
                    değerlendirme imkanı vermektir. Böylece daha bilinçli ve objektif bir kamu oluşturmayı hedefliyoruz.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Nasıl Çalışır?</h2>
                <div class="space-y-4">
                    <div class="bg-dark-card p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-white mb-2">1. Haber Toplama</h3>
                        <p class="text-gray-400">
                            34 farklı haber kaynağından otomatik olarak haberler toplanır.
                            Bu kaynaklar sol, merkez ve sağ perspektifleri temsil eder.
                        </p>
                    </div>
                    <div class="bg-dark-card p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-white mb-2">2. Yapay Zeka Analizi</h3>
                        <p class="text-gray-400">
                            Google Gemini AI kullanarak benzer haberleri gruplar, siyasi eğilim dağılımını hesaplar
                            ve her perspektiften özet çıkarır.
                        </p>
                    </div>
                    <div class="bg-dark-card p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-white mb-2">3. Gölge Gündem</h3>
                        <p class="text-gray-400">
                            Bir tarafın görmezden geldiği haberleri özel olarak vurgular, böylece hangi konuların
                            hangi perspektifler tarafından önemsenmediğini görmenizi sağlar.
                        </p>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Tarafsız mıyız?</h2>
                <p class="mb-4">
                    Eksen olarak hiçbir siyasi görüşü desteklemiyoruz veya eleştirmiyoruz. Platformumuz tamamen
                    algoritmik ve yapay zeka tabanlıdır; elle yapılan hiçbir editoryal müdahale yoktur.
                </p>
                <p>
                    Kaynak seçimimiz dengeli bir spektrum oluşturacak şekilde yapılmıştır. Tüm kaynaklarımızın
                    siyasi eğilim skorları şeffaf bir şekilde hesaplanır ve gösterilir.
                </p>
            </section>

            <section class="bg-dark-card p-8 rounded-lg">
                <h2 class="text-2xl font-bold text-white mb-4">İletişim</h2>
                <p class="mb-2">Sorularınız veya önerileriniz için bizimle iletişime geçebilirsiniz:</p>
                <p class="text-bias-right">info@eksen.com.tr</p>
            </section>
        </div>
    </div>

    @include('components.footer')

</body>

</html>