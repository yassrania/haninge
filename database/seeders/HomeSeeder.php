<?php

namespace Database\Seeders;

use App\Models\HomeSetting;
use Illuminate\Database\Seeder;

class HomeSeeder extends Seeder
{
    public function run(): void
    {
        HomeSetting::firstOrCreate([], [
            'hero_mode' => 'slider',
            'slides' => [
                ['type'=>'image','image'=>null,'caption'=>'Välkommen till moskén','button_text'=>'Läs mer','button_url'=>'/om-oss'],
            ],
            'about_title' => 'Om moskén',
            'about_body'  => 'En plats för gemenskap och kunskap.',
            'goals' => [
                ['title'=>'Utbildning','body'=>'Kurser och föreläsningar','image'=>null],
                ['title'=>'Gemenskap','body'=>'Aktiviteter för alla','image'=>null],
            ],
            'pillars' => [
                ['title'=>'Shahada','body'=>null],
                ['title'=>'Salah','body'=>null],
                ['title'=>'Zakat','body'=>null],
                ['title'=>'Sawm','body'=>null],
                ['title'=>'Hajj','body'=>null],
            ],
            'services_title' => 'Våra tjänster',
            'services_desc'  => 'Tjänster som vi erbjuder i moskén.',
            'services' => [
                ['title'=>'Vigsel','body'=>'Islamisk vigsel','image'=>null,'button_text'=>'Läs mer','button_url'=>'/tjanster/vigsel'],
            ],
            'cta_title' => 'Stöd moskén',
            'cta_subtitle' => 'Ditt stöd gör skillnad',
            'cta_button_text' => 'Donera',
            'cta_button_url' => '/donera',
            'show_latest_news' => true,
            'latest_news_limit' => 6,
        ]);
    }
}
