<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        // $diceCode = '123456'; // Adjust or make dynamic if needed

        $subjects = [
            // General stream (Classes 6th–10th)
            ['name' => 'Hindi', 'stream' => 'General', 'class' => '6th', 'dice_code' => $diceCode],
            ['name' => 'English', 'stream' => 'General', 'class' => '6th', 'dice_code' => $diceCode],
            ['name' => 'Math', 'stream' => 'General', 'class' => '6th', 'dice_code' => $diceCode],
            ['name' => 'Science', 'stream' => 'General', 'class' => '7th', 'dice_code' => $diceCode],
            ['name' => 'Social Studies', 'stream' => 'General', 'class' => '8th', 'dice_code' => $diceCode],
            ['name' => 'English', 'stream' => 'General', 'class' => '9th', 'dice_code' => $diceCode],
            ['name' => 'Hindi', 'stream' => 'General', 'class' => '10th', 'dice_code' => $diceCode],

            // Arts stream (11th–12th)
            ['name' => 'History', 'stream' => 'Arts', 'class' => '11th', 'dice_code' => $diceCode],
            ['name' => 'Geography', 'stream' => 'Arts', 'class' => '11th', 'dice_code' => $diceCode],
            ['name' => 'Political Science', 'stream' => 'Arts', 'class' => '12th', 'dice_code' => $diceCode],

            // Science stream (11th–12th)
            ['name' => 'Physics', 'stream' => 'Science', 'class' => '11th', 'dice_code' => $diceCode],
            ['name' => 'Chemistry', 'stream' => 'Science', 'class' => '11th', 'dice_code' => $diceCode],
            ['name' => 'Biology', 'stream' => 'Science', 'class' => '12th', 'dice_code' => $diceCode],
            ['name' => 'Mathematics', 'stream' => 'Science', 'class' => '12th', 'dice_code' => $diceCode],

            // Commerce stream (11th–12th)
            ['name' => 'Business Studies', 'stream' => 'Commerce', 'class' => '11th', 'dice_code' => $diceCode],
            ['name' => 'Accountancy', 'stream' => 'Commerce', 'class' => '11th', 'dice_code' => $diceCode],
            ['name' => 'Economics', 'stream' => 'Commerce', 'class' => '12th', 'dice_code' => $diceCode],

            // Agriculture stream (11th–12th)
            ['name' => 'Crop Production', 'stream' => 'Agriculture', 'class' => '11th', 'dice_code' => $diceCode],
            ['name' => 'Soil Science', 'stream' => 'Agriculture', 'class' => '12th', 'dice_code' => $diceCode],
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate([
                'name' => $subject['name'],
                'stream' => $subject['stream'],
                'class' => $subject['class'],
                'dice_code' => $subject['dice_code'],
            ]);
        }
    }
}
