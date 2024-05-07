<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public static $seedType = "full";
    //public static $seedLanguage = "pt_PT";
    public static $seedLanguage = "en_US";

    public static function readCSVFile($filename, $startFromRow = 1): array
    {
        $line_of_text = [];
        $file_handle = fopen($filename, 'r');
        try {
            while (!feof($file_handle)) {
                $line = fgetcsv($file_handle, 0, ';');
                if (empty($line)) {
                    continue;
                }
                if ((count($line) == 1) && (trim($line[0]) == '')) {
                    continue;
                }
                $line_of_text[] = $line;
            }
        } finally {
            fclose($file_handle);
        }

        return array_slice($line_of_text, $startFromRow - 1);
    }


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function runComplete()
    {
        DB::statement("SET foreign_key_checks=0");

        DB::table('configuration')->delete();
        DB::table('genres')->delete();
        DB::table('users')->delete();
        DB::table('customers')->delete();
        DB::table('movies')->delete();
        DB::table('theaters')->delete();
        DB::table('seats')->delete();
        DB::table('screenings')->delete();
        DB::table('purchases')->delete();
        DB::table('tickets')->delete();

        DB::statement('ALTER TABLE configuration AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE movies AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE theaters AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE seats AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE screenings AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE purchases AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE tickets AUTO_INCREMENT = 0');

        DB::statement("SET foreign_key_checks=1");

        $this->call(ConfigurationSeeder::class);
        $this->call(GenresSeeder::class);
        $this->call(MoviesSeeder::class);
        $this->call(TheatersSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ScreeningsSeeder::class);
    }

    public function runIncremental()
    {
        $this->call(ScreeningsSeeder::class);
    }

    public function run()
    {
        $this->command->info("-----------------------------------------------");
        $this->command->info("START of database seeder");
        $this->command->info("-----------------------------------------------");
        if (DB::table('genres')->count() == 0) {
            DatabaseSeeder::$seedType = 'complete';
        } else {
            DatabaseSeeder::$seedType = $this->command->choice('What type of seeder do you want to apply? ("complete" to recreate all DB; "incremental" to only add screenings, tickets and purchases to dates after the last "seeder")', ['complete', 'incremental'], 1);
            if (DatabaseSeeder::$seedType == 'complete') {
                $this->command->info("-----------------------------------------------");
                $this->command->info("'complete' seed - all data will be deleted and rebuilt again");
                $this->command->info("-----------------------------------------------");
            } else {
                $this->command->info("-----------------------------------------------");
                $this->command->info("'incremental' seed- only adds screenings, tickets and purchases for most recent days");
                $this->command->info("-----------------------------------------------");
            }
        }
        if (DatabaseSeeder::$seedType == 'complete') {
            $this->command->info("");
            $this->command->info("");
            $this->command->info("Movie names are mostly in portuguese (some are in english), but we can change the language for the user's and customer names.");
            $language = $this->command->choice('What language to use on the names of users/customers? "USA (english)" for USA english; "PT (Portuguese)" for Portugal (portuguese)', ['USA (english)', 'PT (Portuguese)'], 0);
            DatabaseSeeder::$seedLanguage = $language == 'PT (Portuguese)' ? 'pt_PT' : 'en_US';
            $this->runComplete();
        } else {
            $this->runIncremental();
        }

        $this->command->info("-----------------------------------------------");
        $this->command->info("END of database seeder");
        $this->command->info("-----------------------------------------------");
    }

}
