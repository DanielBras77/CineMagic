<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class GenresSeeder extends Seeder
{
    public static $genres = [
        "COMEDY" => "Comedy",
        "SCI-FI" => "Science fiction",
        "HORROR" => "Horror",
        "ROMANCE" => "Romance",
        "ACTION" => "Action",
        "THRILLER" => "Suspense",
        "DRAMA" => "Drama",
        "MISTERY" => "Mystery",
        "CRIME" => "Crime",
        "ANIMATION" => "Animation",
        "ADVENTURE" => "Adventure",
        "FAMILY" => "Family",
        "FANTASY" => "Fantasy",
        "COMEDY-ROMANCE" => "Romantic comedy",
        "COMEDY-ACTION" => "Comedy and action",
        "SUPERHERO" => "Super heroes",
        "MUSICAL" => "Musical",
        "BIBLOGRAPHY" => "Bibliography",
        "HISTORY" => "Historical",
        "WESTERN" => "Western",
        "WAR" => "War",
        "CULT" => "Cult movie",
        "SILENT" => "Silent Movie",
    ];

    // Genres - usar esta tabela para associar aos seeds dos movies
    public static $genresPT = [
        "COMEDY" => "Comédia",
        "SCI-FI" => "Ficção científica",
        "HORROR" => "Terror",
        "ROMANCE" => "Romance",
        "ACTION" => "Acção",
        "THRILLER" => "Suspense",
        "DRAMA" => "Drama",
        "MISTERY" => "Mistério",
        "CRIME" => "Crime",
        "ANIMATION" => "Animação",
        "ADVENTURE" => "Aventura",
        "FAMILY" => "Família",
        "FANTASY" => "Fantasia",
        "COMEDY-ROMANCE" => "Comédia romântica",
        "COMEDY-ACTION" => "Comédia e acção",
        "SUPERHERO" => "Super herois",
        "MUSICAL" => "Musical",
        "BIBLOGRAPHY" => "Bibliografia",
        "HISTORY" => "Histórico",
        "WESTERN" => "Western",
        "WAR" => "Guerra",
        "CULT" => "Movie de culto",
        "SILENT" => "Movie silencioso",
    ];

    public function run()
    {
        $this->command->info("Genres of movies");
        foreach (GenresSeeder::$genres as $key => $value) {
            DB::table('genres')->insert([
                'code' => $key,
                'name' => $value,
                'deleted_at' => null
            ]);
        }
        $faker = \Faker\Factory::create(DatabaseSeeder::$seedLanguage);
        DB::table('genres')
            ->where('code', 'SILENT')
            ->update(['deleted_at' =>  $faker->dateTimeBetween('-3 months', '-1 months')]);
    }
}
