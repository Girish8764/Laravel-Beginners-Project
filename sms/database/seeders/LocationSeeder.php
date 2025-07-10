<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $rajasthan = Location::create(['name' => 'Rajasthan', 'type' => 'state']);
        $punjab = Location::create(['name' => 'Punjab', 'type' => 'state']);

        Location::insert([
            ['name' => 'Jaipur', 'type' => 'district', 'parent_id' => $rajasthan->id],
            ['name' => 'Jodhpur', 'type' => 'district', 'parent_id' => $rajasthan->id],
            ['name' => 'Ludhiana', 'type' => 'district', 'parent_id' => $punjab->id],
            ['name' => 'Amritsar', 'type' => 'district', 'parent_id' => $punjab->id],
        ]);
    }
}
