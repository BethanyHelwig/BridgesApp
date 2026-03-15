<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // State::factory->count(50)->create();

        // Path to JSON file with data
        $jsonFile = base_path('database\seeders\data\state_data.json');

        // Read and decode the JSON file
        $jsonData = json_decode(File::get($jsonFile), true);

        // Create objects for each data piece so it includes the timestamps
        foreach ($jsonData as $data) {
            State::create(array(
                'name' => $data['name'],
                'abbreviation' => $data['abbreviation']
            ));
        }
    }
}
