<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\City;
use App\Models\State;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to JSON file with data
        $jsonFile = base_path('database\seeders\data\city_data.json');

        // Read and decode the JSON file
        $jsonData = json_decode(File::get($jsonFile), true);

        // Create objects for each data piece so it includes the timestamps
        foreach ($jsonData as $data) {
            City::create(array(
                'county_name' => $data['county_name'],
                'zip' => $data['zip'],
                'city_name' => $data['city_name'],
                'state_id' => $data['state_id']
            ));
        }
    }
}
