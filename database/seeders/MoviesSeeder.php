<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

class MoviesSeeder extends Seeder
{
    public static $arrayMovies = [];
    private $postersPublicPath = 'public/posters';

    public function run()
    {
        $this->command->info("Movies");
        $this->command->info("Read movies database");
        static::$arrayMovies = DatabaseSeeder::readCSVFile(database_path("seeders/db_movies/moviesDB.csv"), 3);
        $faker = \Faker\Factory::create(DatabaseSeeder::$seedLanguage);
        $this->cleanFilesPosters();
        $movies = [];
        foreach(static::$arrayMovies as $movie) {
            $newMovie = $this->newMovie($faker, $movie);
            if ($newMovie) {
                $movies[] = $newMovie;
            }
        }
        $this->command->info("Save all movies in block on the database");
        $this->saveNoPosterImages();

        DB::table('movies')->insert($movies);
        // Next, let's copy the posters images
        $this->command->info("Copying poster images");
        $movies = DB::table('movies')->get();
        foreach ($movies as $movie) {
            if ($movie->poster_filename) {
                $this->savePoster($movie->id, $movie->poster_filename);
            }
        }
    }

    private function newMovie($faker, $movieRow)
    {
        $idx = $movieRow[0];
        $genre = $movieRow[1];
        $title = $movieRow[2];
        $year = $movieRow[3];
        $poster = $movieRow[4];
        $synopsis = $movieRow[5];
        $trailer = $movieRow[6];
        if (trim($genre) == '') {
            return null;
        }
        $title = trim($title) == '' ? 'Movie ' . $genre . ' ' . ($idx-1) : trim($title);
        $year = trim($year) == '' ? '2024' : trim($year);
        $poster = trim($poster) == '' ? null : trim($poster);
        $synopsis = trim($synopsis) == '' ? $faker->realText(100): trim($synopsis);
        $trailer = trim($trailer) == '' ? null : trim($trailer);
        $createdAt = $faker->dateTimeBetween('-3 years', '-3 months');
        $updatedAt = $faker->dateTimeBetween($createdAt, '-1 months');
        return [
            'title' => $title,
            'genre_code' => $genre,
            'year' => $year,
            'poster_filename' => $poster,
            'synopsis' => $synopsis,
            'trailer_url' => $trailer,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }

    private function savePoster($id, $file)
    {
        $fileName = database_path('seeders/posters') . '/' . $file;
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $targetDir = storage_path('app/' . $this->postersPublicPath);
        $newfilename = $id . "_" . uniqid() . '.' . $ext;
        File::copy($fileName, $targetDir . '/' . $newfilename);
        DB::table('movies')->where('id', $id)->update(['poster_filename' => $newfilename]);
        $this->command->info("Atualizada imagem do poster $id. Name do file copiado = $newfilename");
    }

    private function saveNoPosterImages()
    {
        for ($i = 1; $i <= 2 ; $i++) {
            $fileName = "_no_poster_$i.png";
            $targetDir = storage_path('app/' . $this->postersPublicPath);
            File::copy(
                database_path('seeders/posters') . "/$fileName",
                $targetDir . "/$fileName"
            );
        }
        $this->command->info("Copied 2 alternative images for movies with no posters");
    }

    private function cleanFilesPosters()
    {
        Storage::deleteDirectory($this->postersPublicPath);
        Storage::makeDirectory($this->postersPublicPath);
    }

    private function getNameFromFilename($filename)
    {
        $strName = str_replace(".png", "", $filename);
        $strName = str_replace("_", " ", $strName);
        $strName = str_replace("-", " ", $strName);
        return ucfirst($strName);
    }
}
