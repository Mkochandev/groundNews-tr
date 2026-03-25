<!DOCTYPE html>
<html lang="tr" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metodoloji - Eksen</title>

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
        <h1 class="text-4xl font-bold text-white mb-6">Metodoloji</h1>

        <div class="space-y-8 text-gray-300 leading-relaxed">
            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Haber Kaynakları</h2>
                <p class="mb-4">
                    Eksen, 34 farklı Türk haber kaynağından otomatik olarak haber toplar. Bu kaynaklar,
                    siyasi spektrumun tüm taraflarını temsil edecek şekilde seçilmiştir:
                </p>
                <div class="grid md:grid-cols-3 gap-4">
                    <div class="bg-dark-card p-4 rounded-lg border-l-4 border-bias-left">
                        <h3 class="font-bold text-bias-left mb-2">Sol Perspektif</h3>
                        <p class="text-sm text-gray-400">Sözcü, Cumhuriyet, BirGün, Halk TV gibi kaynaklar</p>
                    </div>
                    <div class="bg-dark-card p-4 rounded-lg border-l-4 border-bias-center">
                        <h3 class="font-bold text-bias-center mb-2">Merkez</h3>
                        <p class="text-sm text-gray-400">NTV, Hürriyet, Milliyet gibi ana akım kaynaklar</p>
                    </div>
                    <div class="bg-dark-card p-4 rounded-lg border-l-4 border-bias-right">
                        <h3 class="font-bold text-bias-right mb-2">Sağ Perspektif</h3>
                        <p class="text-sm text-gray-400">Sabah, Yeni Şafak, A Haber gibi kaynaklar</p>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Siyasi Eğilim Skorlaması</h2>
                <p class="mb-4">
                    Her haber kaynağına -10 (sol) ile +10 (sağ) arasında bir siyasi eğilim skoru atanmıştır:
                </p>
                <div class="bg-dark-card p-6 rounded-lg">
                    <div class="space-y-3">
                        <div class="flex items-center gap-4">
                            <span class="text-bias-left font-bold w-32">-10 ila -3:</span>
                            <span class="text-gray-400">Sol eğilimli (Sözcü, Cumhuriyet vb.)</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-bias-center font-bold w-32">-2 ila +2:</span>
                            <span class="text-gray-400">Merkez/Tarafsız (NTV, CNN Türk vb.)</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-bias-right font-bold w-32">+3 ila +10:</span>
                            <span class="text-gray-400">Sağ eğilimli (Sabah, Yeni Şafak vb.)</span>
                        </div>
                    </div>
                </div>
                <p class="mt-4 text-sm text-gray-500">
                    Bu skorlar, kaynakların genel editoryal çizgisi, sahiplik yapısı ve içerik analizi dikkate alınarak
                    belirlenmiştir.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Yapay Zeka Analizi</h2>
                <p class="mb-4">
                    Toplanan haberler Google Gemini yapay zeka modeli kullanılarak analiz edilir:
                </p>
                <div class="space-y-4">
                    <div class="bg-dark-card p-5 rounded-lg">
                        <h3 class="text-lg font-semibold text-white mb-2">🔍 1. Haber Gruplama</h3>
                        <p class="text-gray-400 text-sm">
                            Benzer konuları işleyen haberler otomatik olarak gruplandırılır. Bu sayede aynı olayın
                            farklı kaynaklardaki yansımalarını bir arada görebilirsiniz.
                        </p>
                    </div>
                    <div class="bg-dark-card p-5 rounded-lg">
                        <h3 class="text-lg font-semibold text-white mb-2">📊 2. Bias Dağılımı</h3>
                        <p class="text-gray-400 text-sm">
                            Her haber grubunda hangi siyasi perspektiflerin ne oranda temsil edildiği hesaplanır.
                            Örneğin: %40 Sol, %30 Merkez, %30 Sağ
                        </p>
                    </div>
                    <div class="bg-dark-card p-5 rounded-lg">
                        <h3 class="text-lg font-semibold text-white mb-2">📝 3. Perspektif Özetleri</h3>
                        <p class="text-gray-400 text-sm">
                            Her perspektif için ayrı bir özet oluşturulur. Sol perspektif nasıl yaklaşıyor?
                            Sağ perspektif neyi vurguluyor? Merkez ne diyor? Hepsi ayrı ayrı özetlenir.
                        </p>
                    </div>
                    <div class="bg-dark-card p-5 rounded-lg">
                        <h3 class="text-lg font-semibold text-white mb-2">🎯 4. Çerçeveleme Analizi</h3>
                        <p class="text-gray-400 text-sm">
                            Farklı medya organlarının olayı nasıl çerçevelediği, hangi kelimeleri kullandığı
                            ve hangi perspektifleri öne çıkardığı analiz edilir.
                        </p>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-white mb-4">Gölge Gündem Algoritması</h2>
                <p class="mb-4">
                    Bir haber grubunda eğer bir perspektifin temsili %60'ın üzerindeyse, bu haber "Gölge Gündem" olarak
                    işaretlenir:
                </p>
                <div class="bg-dark-card p-6 rounded-lg space-y-4">
                    <div class="flex items-start gap-4">
                        <span class="text-2xl">🔵</span>
                        <div>
                            <h3 class="font-bold text-bias-right mb-1">Sağın Gölgesinde Kaldı</h3>
                            <p class="text-sm text-gray-400">
                                Sol kaynaklarda %60+ haber var, ancak sağ kaynaklar bu haberi görmezden geliyor.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="text-2xl">🔴</span>
                        <div>
                            <h3 class="font-bold text-bias-left mb-1">Solun Gölgesinde Kaldı</h3>
                            <p class="text-sm text-gray-400">
                                Sağ kaynaklarda %60+ haber var, ancak sol kaynaklar bu haberi görmezden geliyor.
                            </p>
                        </div>
                    </div>
                </div>
                <p class="mt-4 text-sm text-gray-500">
                    Bu özellik, hangi perspektiflerin hangi haberleri gözden kaçırdığını veya kasıtlı olarak
                    görmezden geldiğini ortaya çıkarır.
                </p>
            </section>

            <section class="bg-gradient-to-r from-bias-left/10 via-bias-center/10 to-bias-right/10 p-8 rounded-lg">
                <h2 class="text-2xl font-bold text-white mb-4">Şeffaflık Taahhüdü</h2>
                <p>
                    Metodolojimiz tamamen açık ve şeffaftır. Hangi kaynakları kullandığımız, nasıl skorladığımız
                    ve yapay zekanın nasıl çalıştığı hakkında tüm bilgiler burada paylaşılmıştır.
                </p>
            </section>
        </div>
    </div>

    @include('components.footer')

</body>

</html>