<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use Illuminate\Support\Facades\Hash;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i <= 5; $i++)
        {
            $movie = Movie::create([
                'title' => 'Judul'. $i,
                'photo' => 'photo.jpg',
                'rating' => '10',
                'price' => '10.000',
                'synopsis' => 'aaaaaaaaaaaaaa',
            ]);

        }
    }
}
