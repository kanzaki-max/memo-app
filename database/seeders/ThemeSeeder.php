<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Theme::insert([
        [
        'name' => '議題',
        'color_name' => 'indigo',
        'is_default' => true
        ],
        [
        'name' => '課題',
        'color_name' => 'red',
        'is_default' => true
        ],
        [
        'name' => 'タスク',
        'color_name' => 'blue',
        'is_default' => true
        ],
        [
        'name' => '決定',
        'color_name' => 'green',
        'is_default' => true
        ],
        ]);
    }
}
