<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Support\Facades\File;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = file_get_contents(__DIR__.'/countries/countries.json');

        foreach (json_decode($countries) as $country) {
            Location::create([
                'country' => $country->name,
            ]);
        }
    }
}
