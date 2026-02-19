<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteContent;

class HeroContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $heroContent = [
            'title' => 'Bangun Karir <span class="text-primary">Impian Anda</span> Bersama SRT Corp',
            'description' => 'Tempat terbaik untuk mengasah potensi dan membangun masa depan yang solid. Jelajahi peluang karier yang dirancang khusus untuk pertumbuhan profesional Anda.',
            'badge_text' => '✨ Bergabung dengan Tim Terbaik',
            'button_text' => 'Lihat Lowongan',
            'stats_employees' => '1000+',
            'stats_security' => 'Terpercaya',
            'stats_global' => 'Global',
            'floating_card_title' => 'Pertumbuhan Karir Cepat',
            'floating_card_desc' => 'Mulai perjalanan profesionalmu hari ini',
            // image intentionally left null to use default fallback in view if not set, or keep existing if exists
        ];

        foreach ($heroContent as $key => $value) {
            SiteContent::updateOrCreate(
                ['section_name' => 'hero', 'content_key' => $key],
                ['content_value' => $value]
            );
        }
    }
}
