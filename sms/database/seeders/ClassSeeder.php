<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $classMap = [
            'LKG' => 'LKG',
            'UKG' => 'UKG',
            'Nursery' => 'Nursery',
            '1' => 'First',
            '2' => 'Second',
            '3' => 'Third',
            '4' => 'Fourth',
            '5' => 'Fifth',
            '6' => 'Sixth',
            '7' => 'Seventh',
            '8' => 'Eighth',
            '9' => 'Ninth',
            '10' => 'Tenth',
            '11' => 'Eleventh',
            '12' => 'Tweleth',
        ];

        foreach ($classMap as $code => $name) {
            DB::table('classes')->insert([
                'code' => $code,
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
