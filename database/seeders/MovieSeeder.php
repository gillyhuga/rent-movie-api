<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = ['Cinderella', 'Raya and The Last Dragon', 'Coming 2 America', 'Godzilla vs Kong', 'Mortal Kombat','Wrath of Man'];
        foreach($title as $t)
        {
            $movie = Movie::create([
                'title' => $t,
                'photo' => 'photo.jpg',
                'rating' => '10',
                'price' => '10.000',
                'synopsis' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vel odio non justo aliquet auctor. Sed vitae maximus magna.',
            ]);

        }
    }
}
