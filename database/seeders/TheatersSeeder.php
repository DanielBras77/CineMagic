<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TheatersSeeder extends Seeder
{
    // Genres - usar esta tabela para associar aos seeds dos movies
    public static $theaters = [];

    public static $theaterNames = [
        "Andromeda",
        "Enterprise",
        "Galatica",
        "Millennium Falcon",
        "X-Wing",
        "Discovery One",
        "Excelsior",
        "Death Star"
    ];

    public static $seats = [
        1 => [10, 15],
        2 => [4, 8],
        3 => [6, 10],
        4 => [7, 8],
        5 => [4, 7],
        6 => [4, 6],
        7 => [8, 6],
        8 => [14, 20]
    ];

    protected function generateSeats($theaterId, $rows, $seat_numbers)
    {
        $alphabet = range('A', 'Z');

        $seats = [];
        for($i=1; $i<=$rows; $i++) {
            $row =  $alphabet[$i-1];
            for($j=1; $j<=$seat_numbers; $j++) {
                $seats[] = [
                    "theater_id" => $theaterId,
                    "row" => $row,
                    "seat_number" => $j,
                ];
            }
        }
        DB::table('seats')->insert($seats);
    }

    public static function fillTheatersInfo()
    {
        foreach (static::$seats as $id => $seats) {
            // static::$theaters array com todas as theaters. Id da theater = chave do array e valor = total de seats (negativo se theater foi apagada)
            static::$theaters[$id] = ($id == 5) ? $seats[0] * $seats[1] * -1 : $seats[0] * $seats[1];
        }
    }

    public function run()
    {
        $this->command->info("Theaters");
        $faker = \Faker\Factory::create(DatabaseSeeder::$seedLanguage);
        foreach (static::$theaterNames as $value) {
            $id = DB::table('theaters')->insert([
                'name' => $value,
                'deleted_at' => $value == "X-Wing" ? $faker->dateTimeBetween('-3 months', '-1 months') : null
            ]);
        }

        foreach (static::$seats as $id => $seats) {
            $this->generateSeats($id, $seats[0], $seats[1]);
        }

        DB::update('update seats set deleted_at = (select deleted_at from theaters where id=5) where theater_id=5');

        static::fillTheatersInfo();

    }
}
