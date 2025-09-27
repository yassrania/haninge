<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menus')->truncate();

        // مستوى أعلى
        $items = [
            ['label' => 'Hem',        'route' => 'home',        'order' => 1],
            ['label' => 'Bönetider',  'route' => 'bonetider',   'order' => 2],
            ['label' => 'Om Islam',   'route' => 'om-islam',    'order' => 3],
            ['label' => 'Om moskén',  'route' => 'om-mosken',   'order' => 4],
            ['label' => 'Nyheter',    'route' => 'nyheter',     'order' => 5],
            ['label' => 'Tjänster',   'route' => 'tjanster',    'order' => 6], // عندها سوبمينو
            ['label' => 'Kontakt',    'route' => 'kontakt',     'order' => 7],
            ['label' => 'Stöd moskén','route' => 'stod-mosken', 'order' => 8],
        ];

        $parents = [];
        foreach ($items as $i) {
            $parents[$i['label']] = Menu::create([
                'label'     => $i['label'],
                'route'     => $i['route'],
                'url'       => null,
                'parent_id' => null,
                'order'     => $i['order'],
                'is_active' => true,
            ]);
        }

        // سوبمينو تحت Tjänster
        $tjanster = $parents['Tjänster'];
        Menu::insert([
            [
                'label' => 'Böner och gudsdyrkan',
                'route' => 'service.boner',
                'url' => null,
                'parent_id' => $tjanster->id,
                'order' => 1,
                'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'label' => 'Islamisk begravning',
                'route' => 'service.begravning',
                'url' => null,
                'parent_id' => $tjanster->id,
                'order' => 2,
                'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'label' => 'Rådgivning',
                'route' => 'service.radgivning',
                'url' => null,
                'parent_id' => $tjanster->id,
                'order' => 3,
                'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'label' => 'Utbildning',
                'route' => 'service.utbildning',
                'url' => null,
                'parent_id' => $tjanster->id,
                'order' => 4,
                'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'label' => 'Vigsel',
                'route' => 'service.vigsel',
                'url' => null,
                'parent_id' => $tjanster->id,
                'order' => 5,
                'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);
        // داخل MenuSeeder لما تنشئ "Stöd moskén"
$parents['Stöd moskén']->update([
    'type' => 'cta',
    'new_tab' => false, // خليه true إذا تبغي يفتح في تبويب جديد
]);

    }
}
