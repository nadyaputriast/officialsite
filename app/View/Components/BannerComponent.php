<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;
use Alkoumi\LaravelHijriDate\Hijri; // Library untuk kalender Hijriah

class BannerComponent extends Component
{
    public $banner;

    public function __construct()
    {
        $this->banner = $this->determineBanner();
    }

    private function determineBanner()
    {
        $today = Carbon::now();
        $defaultBanner = 'banner.svg';

        // Periksa hari raya nasional (prioritas tertinggi)
        $nationalHolidayBanner = $this->getNationalHolidayBanner($today);
        if ($nationalHolidayBanner) {
            return $nationalHolidayBanner;
        }

        // Periksa hari raya keagamaan
        $religiousHolidayBanner = $this->getReligiousHolidayBanner($today);
        if ($religiousHolidayBanner) {
            return $religiousHolidayBanner;
        }

        return $defaultBanner;
    }

    /**
     * Mendapatkan banner untuk hari raya nasional
     */
    private function getNationalHolidayBanner(Carbon $today)
    {
        $month = $today->month;
        $day = $today->day;

        switch (true) {
            case $month == 1 && $day == 1:
                return 'newyear-banner.svg';

            case $month == 8 && $day == 17:
                return 'independence-day-banner.svg'; // Hari Kemerdekaan Indonesia

            case $month == 4 && $day == 14:
                return 'hut-informatika-banner.svg'; // Hut Informatika

            default:
                return null;
        }
    }

    /**
     * Mendapatkan banner untuk hari raya keagamaan
     */
    private function getReligiousHolidayBanner(Carbon $today)
    {
        $defaultBanner = 'banner.svg';

        // 1. Hari Raya Islam (menggunakan library kalender Hijriah)
        try {
            $islamicBanner = $this->getIslamicHolidayBanner();
            if ($islamicBanner) {
                return $islamicBanner;
            }
        } catch (\Exception $e) {
            return $defaultBanner;
        }

        // 2. Hari Raya Hindu
        $hinduBanner = $this->getHinduHolidayBanner($today);
        if ($hinduBanner) {
            return $hinduBanner;
        }

        // 3. Hari Raya Buddha
        $buddhaBanner = $this->getBuddhistHolidayBanner($today);
        if ($buddhaBanner) {
            return $buddhaBanner;
        }

        // 4. Hari Raya Kong Hu Chu
        $kongHuChuBanner = $this->getKongHuChuHolidayBanner($today);
        if ($kongHuChuBanner) {
            return $kongHuChuBanner;
        }

        // 5. Hari Raya Kristen
        $kristenBanner = $this->getKristenHolidayBanner($today);
        if ($kristenBanner) {
            return $kristenBanner;
        }

        return null;
    }

    /**
     * Mendapatkan banner untuk hari raya Islam
     */
    private function getIslamicHolidayBanner()
    {
        // Menggunakan library Hijri untuk mendapatkan tanggal Hijriah
        $hijriDate = Hijri::Date('j-n');
        list($hijriDay, $hijriMonth) = explode('-', $hijriDate);
        $hijriDay = (int)$hijriDay;
        $hijriMonth = (int)$hijriMonth;

        switch (true) {
            // Idul Fitri (1-2 Syawal)
            case $hijriMonth == 10 && ($hijriDay == 1 || $hijriDay == 2):
                return 'idul-fitri-banner.svg';

                // Idul Adha (10 Dzulhijjah)
            case $hijriMonth == 12 && $hijriDay == 10:
                return 'idul-adha-banner.svg';

                // 1 Muharram (Tahun Baru Hijriah)
            case $hijriMonth == 1 && $hijriDay == 1:
                return 'islamic-new-year-banner.svg';

            default:
                return null;
        }
    }

    /**
     * Mendapatkan banner untuk hari raya Hindu
     */
    private function getHinduHolidayBanner(Carbon $today)
    {
        // Nyepi (tanggal tetap)
        $nyepiDates = [
            '2025-03-29', // 29 Maret 2025
            '2026-03-19', // 19 Maret 2026
            '2027-03-08', // 8 Maret 2027
            '2028-03-26', // 26 Maret 2028
            '2029-03-15', // 15 Maret 2029
            '2030-03-05', // 5 Maret 2030
            '2031-03-24', // 24 Maret 2031
        ];

        // Periksa apakah hari ini adalah salah satu tanggal Nyepi
        if (in_array($today->toDateString(), $nyepiDates)) {
            return 'nyepi-banner.svg';
        }

        // Hari Raya Galungan
        $firstGalungan = Carbon::create(2025, 4, 23); // 23 April 2025
        $galunganInterval = 210; // Interval Galungan dalam hari

        // Hitung selisih hari antara hari ini dan tanggal awal Galungan
        $daysDifference = $firstGalungan->diffInDays($today, false); // False untuk menghitung selisih negatif

        // Jika selisih hari >= 0, perbarui tanggal awal Galungan ke siklus terbaru
        if ($daysDifference >= 0) {
            $cyclesPassed = floor($daysDifference / $galunganInterval); // Hitung jumlah siklus yang telah berlalu
            $currentGalungan = $firstGalungan->copy()->addDays($cyclesPassed * $galunganInterval);

            // Periksa apakah hari ini adalah H-1, Hari H, atau H+1 dari Galungan
            if ($today->between($currentGalungan->copy()->subDay(), $currentGalungan->copy()->addDay())) {
                return 'galungan-banner.svg';
            }
        }

        // Hari Raya Siwaratri
        $firstSiwaratri = Carbon::create(2025, 1, 27); // 27 Januari 2025
        $siwaratriInterval = 210; // Interval Siwaratri dalam hari

        // Hitung selisih hari antara hari ini dan tanggal awal Siwaratri
        $daysDifference = $firstSiwaratri->diffInDays($today, false); // False untuk menghitung selisih negatif

        // Jika selisih hari >= 0, perbarui tanggal awal Siwaratri ke siklus terbaru
        if ($daysDifference >= 0) {
            $cyclesPassed = floor($daysDifference / $siwaratriInterval); // Hitung jumlah siklus yang telah berlalu
            $currentSiwaratri = $firstSiwaratri->copy()->addDays($cyclesPassed * $siwaratriInterval);

            // Periksa apakah hari ini adalah tanggal Siwaratri
            if ($today->isSameDay($currentSiwaratri)) {
                return 'siwaratri-banner.svg';
            }
        }

        // Hari Raya Saraswati
        $firstSaraswati = Carbon::create(2025, 9, 6); // 6 September 2025
        $saraswatiInterval = 210; // Interval Saraswati dalam hari

        // Hitung selisih hari antara hari ini dan tanggal awal Saraswati
        $daysDifference = $firstSaraswati->diffInDays($today, false); // False untuk menghitung selisih negatif

        // Jika selisih hari >= 0, perbarui tanggal awal Saraswati ke siklus terbaru
        if ($daysDifference >= 0) {
            $cyclesPassed = floor($daysDifference / $saraswatiInterval); // Hitung jumlah siklus yang telah berlalu
            $currentSaraswati = $firstSaraswati->copy()->addDays($cyclesPassed * $saraswatiInterval);

            // Periksa apakah hari ini adalah tanggal Saraswati
            if ($today->isSameDay($currentSaraswati)) {
                return 'saraswati-banner.svg';
            }
        }

        return null;
    }

    /**
     * Mendapatkan banner untuk hari raya Buddha
     */
    private function getBuddhistHolidayBanner(Carbon $today)
    {
        $waisakDates = [
            '2025-05-12', // 12 Mei 2025
            '2026-05-31', // 31 Mei 2026
            '2027-05-20', // 20 Mei 2027
            '2028-05-09', // 9 Mei 2028
            '2029-05-28', // 28 Mei 2029
            '2030-05-17', // 17 Mei 2030
            '2031-05-07', // 7 Mei 2031
        ];

        // Periksa apakah hari ini adalah salah satu tanggal Waisak
        if (in_array($today->toDateString(), $waisakDates)) {
            return 'waisak-banner.svg';
        }

        return null;
    }

    /**
     * Mendapatkan banner untuk hari raya Kong Hu Chu
     */
    private function getKongHuChuHolidayBanner(Carbon $today)
    {
        // Hari Raya Imlek (tanggal tetap)
        $imlekDates = [
            '2025-01-29', // 29 Januari 2025
            '2026-02-10', // 10 Februari 2026
            '2027-02-05', // 5 Februari 2027
            '2028-01-29', // 29 Januari 2028
            '2029-02-10', // 10 Februari 2029
            '2030-02-04', // 4 Februari 2030
            '2031-01-23', // 23 Januari 2031
        ];

        // Periksa apakah hari ini adalah salah satu tanggal Nyepi
        if (in_array($today->toDateString(), $imlekDates)) {
            return 'imlek-banner.svg';
        }

        // Cap Go Meh (15 hari setelah Imlek)
        foreach ($imlekDates as $imlekDate) {
            $capGoMehDate = Carbon::createFromFormat('Y-m-d', $imlekDate)->addDays(15);
            if ($today->isSameDay($capGoMehDate)) {
                return 'cap-go-meh-banner.svg';
            }
        }

        return null;
    }

    private function getKristenHolidayBanner(Carbon $today)
    {
        // Natal (tanggal tetap)
        if ($today->month == 12 && $today->day == 25) {
            return 'natal-banner.svg';
        }

        // Hitung tanggal Paskah
        $easterDate = $this->calculateEasterDate($today->year);

        // Paskah
        if ($today->isSameDay($easterDate)) {
            return 'paskah-banner.svg';
        }

        // Kenaikan Yesus Kristus (40 hari setelah Paskah)
        $ascensionDate = $easterDate->copy()->addDays(40);
        if ($today->isSameDay($ascensionDate)) {
            return 'kenaikan-yesus-banner.svg';
        }

        return null;
    }

    private function calculateEasterDate($year)
    {
        $a = $year % 19;
        $b = floor($year / 100);
        $c = $year % 100;
        $d = floor($b / 4);
        $e = $b % 4;
        $f = floor(($b + 8) / 25);
        $g = floor(($b - $f + 1) / 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = floor($c / 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = floor(($a + 11 * $h + 22 * $l) / 451);
        $month = floor(($h + $l - 7 * $m + 114) / 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;

        return Carbon::create($year, $month, $day);
    }

    public function render()
    {
        return view('components.banner-component');
    }
}
