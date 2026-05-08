<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\Tribe;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create States
        $states = [
            ['name' => 'Assam', 'slug' => 'assam', 'description' => 'Known for Muga, Pat, and Eri silk weaving traditions.'],
            ['name' => 'Nagaland', 'slug' => 'nagaland', 'description' => 'Home to diverse tribal weaving patterns and shawls.'],
            ['name' => 'Manipur', 'slug' => 'manipur', 'description' => 'Known for intricate handloom designs and traditional attire.'],
            ['name' => 'Mizoram', 'slug' => 'mizoram', 'description' => 'Rich in textile traditions with unique tribal patterns.'],
            ['name' => 'Tripura', 'slug' => 'tripura', 'description' => 'Known for traditional handloom and cotton weaving.'],
            ['name' => 'Meghalaya', 'slug' => 'meghalaya', 'description' => 'Home to traditional weaving by Khasi, Garo, and Jaintia tribes.'],
            ['name' => 'Arunachal Pradesh', 'slug' => 'arunachal-pradesh', 'description' => 'Diverse tribal communities with unique textile traditions.'],
            ['name' => 'Sikkim', 'slug' => 'sikkim', 'description' => 'Known for Buddhist influence in textile designs.']
        ];

        foreach ($states as $stateData) {
            State::create($stateData);
        }

        // Create Tribes
        $tribes = [
            ['name' => 'Assamese', 'slug' => 'assamese', 'state_id' => 1, 'description' => 'Major ethnic group of Assam known for Mekhela Chador.'],
            ['name' => 'Bodo', 'slug' => 'bodo', 'state_id' => 1, 'description' => 'Largest tribal community in Assam with rich weaving traditions.'],
            ['name' => 'Mishing', 'slug' => 'mishing', 'state_id' => 1, 'description' => 'Known for traditional handloom and cotton weaving.'],
            ['name' => 'Khasi', 'slug' => 'khasi', 'state_id' => 6, 'description' => 'Major tribe of Meghalaya known for intricate weaving.'],
            ['name' => 'Garo', 'slug' => 'garo', 'state_id' => 6, 'description' => 'Tribal community with unique textile patterns.'],
            ['name' => 'Naga', 'slug' => 'naga', 'state_id' => 2, 'description' => 'Diverse tribal groups known for distinctive shawls.'],
            ['name' => 'Mizo', 'slug' => 'mizo', 'state_id' => 4, 'description' => 'Tribal community with rich textile heritage.'],
            ['name' => 'Manipuri', 'slug' => 'manipuri', 'state_id' => 3, 'description' => 'Known for traditional attire and dance costumes.']
        ];

        foreach ($tribes as $tribeData) {
            Tribe::create($tribeData);
        }

        // Create Categories
        $categories = [
            ['name' => 'Mekhela Chador', 'slug' => 'mekhela-chador', 'description' => 'Traditional Assamese attire for women.'],
            ['name' => 'Shawls', 'slug' => 'shawls', 'description' => 'Traditional shawls from North-East India.'],
            ['name' => 'Jewelry', 'slug' => 'jewelry', 'description' => 'Traditional tribal jewelry and ornaments.'],
            ['name' => 'Jackets', 'slug' => 'jackets', 'description' => 'Traditional jackets and upper wear.'],
            ['name' => 'Handloom Fabrics', 'slug' => 'handloom-fabrics', 'description' => 'Pure handloom fabrics by the yard.']
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
    }
}
