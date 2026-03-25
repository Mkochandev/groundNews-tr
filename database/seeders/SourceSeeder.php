<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Source;

class SourceSeeder extends Seeder
{
    public function run(): void
    {
        $sources = [
            // --- ANA AKIM & GÜNDEM ---

            // SOL / MUHALİF (-10 to -5)
            [
                'name' => 'Cumhuriyet',
                'url' => 'https://www.cumhuriyet.com.tr',
                'rss_url' => 'http://www.cumhuriyet.com.tr/rss/son_dakika.xml',
                'base_bias' => -9,
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/22/Cumhuriyet_logo.png'
            ],
            [
                'name' => 'Sözcü',
                'url' => 'https://www.sozcu.com.tr',
                'rss_url' => 'https://www.sozcu.com.tr/feeds-son-dakika',
                'base_bias' => -8,
                'logo' => 'https://i.sozcu.com.tr/static/img/assets/logo.png'
            ],
            [
                'name' => 'BirGün',
                'url' => 'https://www.birgun.net',
                'rss_url' => 'https://www.birgun.net/xml/rss.xml',
                'base_bias' => -10,
                'logo' => 'https://static.birgun.net/assets/images/logo.svg'
            ],
            [
                'name' => 'Halk TV',
                'url' => 'https://www.halktv.com.tr',
                'rss_url' => 'https://www.halktv.com.tr/rss',
                'base_bias' => -7,
                'logo' => 'https://www.halktv.com.tr/images/logo.svg'
            ],
            [
                'name' => 'T24',
                'url' => 'https://t24.com.tr',
                'rss_url' => 'https://t24.com.tr/rss',
                'base_bias' => -6,
                'logo' => 'https://t24.com.tr/assets/img/logo/logo.svg'
            ],
            [
                'name' => 'Gazete Duvar',
                'url' => 'https://www.gazeteduvar.com.tr',
                'rss_url' => 'https://www.gazeteduvar.com.tr/rss',
                'base_bias' => -8,
                'logo' => 'https://www.gazeteduvar.com.tr/ static/img/logo.png'
            ],
            [
                'name' => 'Diken',
                'url' => 'http://www.diken.com.tr',
                'rss_url' => 'http://www.diken.com.tr/feed/',
                'base_bias' => -7,
                'logo' => 'http://www.diken.com.tr/wp-content/themes/diken_v1/img/diken_logo.png'
            ],
            [
                'name' => 'Tele1',
                'url' => 'https://tele1.com.tr',
                'rss_url' => 'https://tele1.com.tr/feed/',
                'base_bias' => -9,
                'logo' => 'https://tele1.com.tr/wp-content/uploads/2019/02/tele1-logo.png'
            ],
            [
                'name' => 'Evrensel',
                'url' => 'https://www.evrensel.net',
                'rss_url' => 'https://www.evrensel.net/rss/haber.xml',
                'base_bias' => -10,
                'logo' => 'https://www.evrensel.net/assets/images/logo.svg'
            ],

            // MERKEZ (-2 to +2)
            [
                'name' => 'Habertürk',
                'url' => 'https://www.haberturk.com',
                'rss_url' => 'https://www.haberturk.com/rss',
                'base_bias' => -1,
                'logo' => 'https://im.haberturk.com/assets/images/logo/haberturk-logo.svg'
            ],
            [
                'name' => 'NTV',
                'url' => 'https://www.ntv.com.tr',
                'rss_url' => 'https://www.ntv.com.tr/gundem.rss',
                'base_bias' => 0,
                'logo' => 'https://cdn.ntv.com.tr/img/logo.svg'
            ],
            [
                'name' => 'CNN Türk',
                'url' => 'https://www.cnnturk.com',
                'rss_url' => 'https://www.cnnturk.com/feed/rss/all/news',
                'base_bias' => 0,
                'logo' => 'https://assets.cnnturk.com/assets/images/logo.svg'
            ],
            [
                'name' => 'Hürriyet',
                'url' => 'https://www.hurriyet.com.tr',
                'rss_url' => 'https://www.hurriyet.com.tr/rss/anasayfa',
                'base_bias' => -1,
                'logo' => 'https://i.hurimg.com/i/hurriyet/75/0x0/5d792686c03c0e2dd0e5138c.jpg'
            ],
            [
                'name' => 'Milliyet',
                'url' => 'https://www.milliyet.com.tr',
                'rss_url' => 'https://www.milliyet.com.tr/rss/rssNew/gundemRss.xml',
                'base_bias' => 1,
                'logo' => 'https://www.milliyet.com.tr/assets/images/milliyet-logo-v2.svg'
            ],
            [
                'name' => 'Onedio',
                'url' => 'https://onedio.com',
                'rss_url' => 'https://onedio.com/support/rss.xml',
                'base_bias' => -2,
                'logo' => 'https://static.onedio.com/images/logo/onedio-new.svg'
            ],
            [
                'name' => 'Karar',
                'url' => 'https://www.karar.com',
                'rss_url' => 'https://www.karar.com/rss/son-dakika.xml',
                'base_bias' => -3,
                'logo' => 'https://cdn.karar.com/assets/images/logo.svg'
            ],
            [
                'name' => 'Haberler.com',
                'url' => 'https://www.haberler.com',
                'rss_url' => 'https://rss.haberler.com/rss.asp',
                'base_bias' => 0,
                'logo' => 'https://www.haberler.com/static/img/logo.png'
            ],
            [
                'name' => 'SonDakika.com',
                'url' => 'https://www.sondakika.com',
                'rss_url' => 'https://www.sondakika.com/rss/haberler.xml',
                'base_bias' => 0,
                'logo' => 'https://www.sondakika.com/static/img/logo.png'
            ],


            // SAĞ / İKTİDAR (+5 to +10)
            [
                'name' => 'Sabah',
                'url' => 'https://www.sabah.com.tr',
                'rss_url' => 'https://www.sabah.com.tr/rss/gundem.xml',
                'base_bias' => 9,
                'logo' => 'https://isbh.tmgrup.com.tr/sbh/v5/i/logo-big.png'
            ],
            [
                'name' => 'Yeni Şafak',
                'url' => 'https://www.yenisafak.com',
                'rss_url' => 'https://www.yenisafak.com/rss',
                'base_bias' => 8,
                'logo' => 'https://assets.yenisafak.com/yenisafak/assets/images/logo.svg'
            ],
            [
                'name' => 'Ensonhaber',
                'url' => 'https://www.ensonhaber.com',
                'rss_url' => 'https://www.ensonhaber.com/rss/ensonhaber.xml',
                'base_bias' => 5,
                'logo' => 'https://icdn.ensonhaber.com/resimler/logo/ensonhaber-logo.png'
            ],
            [
                'name' => 'A Haber',
                'url' => 'https://www.ahaber.com.tr',
                'rss_url' => 'https://www.ahaber.com.tr/rss/gundem.xml',
                'base_bias' => 10,
                'logo' => 'https://iahbr.tmgrup.com.tr/v5/i/logo.png'
            ],
            [
                'name' => 'Star',
                'url' => 'https://www.star.com.tr',
                'rss_url' => 'https://www.star.com.tr/rss/rss.xml',
                'base_bias' => 9,
                'logo' => 'https://www.star.com.tr/assets/images/logo.png'
            ],
            [
                'name' => 'Türkiye Gazetesi',
                'url' => 'https://www.turkiyegazetesi.com.tr',
                'rss_url' => 'https://www.turkiyegazetesi.com.tr/rss/gundem.xml',
                'base_bias' => 8,
                'logo' => 'https://www.turkiyegazetesi.com.tr/assets/img/logo.png'
            ],
            [
                'name' => 'Akşam',
                'url' => 'https://www.aksam.com.tr',
                'rss_url' => 'https://www.aksam.com.tr/rss/gundem.xml',
                'base_bias' => 7,
                'logo' => 'https://www.aksam.com.tr/assets/images/logo.png'
            ],
            [
                'name' => 'Takvim',
                'url' => 'https://www.takvim.com.tr',
                'rss_url' => 'https://www.takvim.com.tr/rss/gundem.xml',
                'base_bias' => 9,
                'logo' => 'https://www.takvim.com.tr/assets/images/logo.png'
            ],
            [
                'name' => 'Yeni Akit',
                'url' => 'https://www.yeniakit.com.tr',
                'rss_url' => 'https://www.yeniakit.com.tr/rss/haber.xml',
                'base_bias' => 10,
                'logo' => 'https://cdn.yeniakit.com.tr/images/logo.png'
            ],

            // HABER AJANSLARI & DEVLET (Bias: 0/State)
            [
                'name' => 'Anadolu Ajansı',
                'url' => 'https://www.aa.com.tr',
                'rss_url' => 'https://www.aa.com.tr/tr/rss/default?cat=guncel',
                'base_bias' => 3, // Devlet/Hükümet yanlısı olabilir
                'logo' => 'https://www.aa.com.tr/assets/images/aa-logo-small.png'
            ],
            [
                'name' => 'TRT Haber',
                'url' => 'https://www.trthaber.com',
                'rss_url' => 'https://www.trthaber.com/gundem_articles.rss',
                'base_bias' => 2, // Devlet kanalı
                'logo' => 'https://cdn.trthaber.com/static/images/trthaber-logo.svg'
            ],
            [
                'name' => 'İHA',
                'url' => 'https://www.iha.com.tr',
                'rss_url' => 'https://www.iha.com.tr/rss',
                'base_bias' => 0,
                'logo' => 'https://www.iha.com.tr/assets/images/logo.png'
            ],


            // --- EKONOMİ & FİNANS (Bias: 0) ---
            [
                'name' => 'Bloomberg HT',
                'url' => 'https://www.bloomberght.com',
                'rss_url' => 'https://www.bloomberght.com/rss',
                'base_bias' => 0,
                'logo' => 'https://assets.bloomberght.com/assets/img/logo_v2.svg'
            ],
            [
                'name' => 'Dünya',
                'url' => 'https://www.dunya.com',
                'rss_url' => 'https://www.dunya.com/rss',
                'base_bias' => 0,
                'logo' => 'https://www.dunya.com/assets/images/logo.png'
            ],

            // --- TEKNOLOJİ (Bias: 0) ---
            [
                'name' => 'DonanımHaber',
                'url' => 'https://www.donanimhaber.com',
                'rss_url' => 'https://www.donanimhaber.com/rss/tum/',
                'base_bias' => 0,
                'logo' => 'https://www.donanimhaber.com/images/dh-logo-2023.svg'
            ],
            [
                'name' => 'Webtekno',
                'url' => 'https://www.webtekno.com',
                'rss_url' => 'https://www.webtekno.com/rss.xml',
                'base_bias' => 0,
                'logo' => 'https://www.webtekno.com/images/logo-v2.svg'
            ],
        ];

        foreach ($sources as $source) {
            Source::updateOrCreate(
                ['name' => $source['name']],
                $source
            );
        }
    }
}