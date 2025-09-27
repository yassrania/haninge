<?php

// database/seeders/FooterSeeder.php
namespace Database\Seeders;

use App\Models\FooterLink;
use App\Models\FooterLinkGroup;
use App\Models\FooterSetting;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder
{
    public function run(): void
    {
        $setting = FooterSetting::first() ?? FooterSetting::create([
            'brand_logo' => null,
            'brand_alt'  => 'Haninge Islamiska Forum',
            'brand_text' => 'En moské för gemenskap, kunskap och omtanke.',
            'address'    => 'Haninge, Sverige',
            'phone'      => '08-xxx xx xx',
            'email'      => 'info@haningeislamiskaforum.se',
            'opening_hours' => [
                ['label' => 'Mån–Fre', 'value' => 'Öppet för bön (se tider)'],
                ['label' => 'Lör–Sön', 'value' => 'Öppet för bön (se tider)'],
            ],
            'social_links' => [
                ['platform' => 'Facebook', 'url' => '#'],
                ['platform' => 'Instagram', 'url' => '#'],
            ],
            'bottom_text' => '© '.date('Y').' Haninge Islamiska Forum. Alla rättigheter förbehållna.',
        ]);

        $services = FooterLinkGroup::firstOrCreate(['title' => 'Våra tjänster'], ['sort' => 1]);
        $quick    = FooterLinkGroup::firstOrCreate(['title' => 'Snabblänkar'], ['sort' => 2]);

        FooterLink::firstOrCreate(['footer_link_group_id'=>$services->id,'label'=>'Bön & gudsdyrkan'], ['url'=>'/tjanster/boner-och-gudsdyrkan','sort'=>1]);
        FooterLink::firstOrCreate(['footer_link_group_id'=>$services->id,'label'=>'Vigsel'], ['url'=>'/tjanster/vigsel','sort'=>2]);
        FooterLink::firstOrCreate(['footer_link_group_id'=>$services->id,'label'=>'Begravning'], ['url'=>'/tjanster/islamisk-begravning','sort'=>3]);
        FooterLink::firstOrCreate(['footer_link_group_id'=>$services->id,'label'=>'Rådgivning'], ['url'=>'/tjanster/radgivning','sort'=>4]);

        FooterLink::firstOrCreate(['footer_link_group_id'=>$quick->id,'label'=>'Om oss'], ['url'=>'/om-oss','sort'=>1]);
        FooterLink::firstOrCreate(['footer_link_group_id'=>$quick->id,'label'=>'Kontakt'], ['url'=>'/kontakt','sort'=>2]);
        FooterLink::firstOrCreate(['footer_link_group_id'=>$quick->id,'label'=>'Evenemang'], ['url'=>'/evenemang','sort'=>3]);
        FooterLink::firstOrCreate(['footer_link_group_id'=>$quick->id,'label'=>'Donera'], ['url'=>'/donera','sort'=>4]);
    }
}
