<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Carbon\Carbon;


class ScreeningsSeeder extends Seeder
{
    private $numberOfYears = 2;
    private $numberOfAvgSessionPerMovie = 24;
    private $deltaSessionPerMovieDown = 20;
    private $deltaSessionPerMovieUp = 50;
    private $numberOfDaysAfterToday = 10;
    private $seats = [];
    private $avgTaxaOcupacao = 20;
    private $schedulesScreening = [  // Domingo, Segunda, etc... 12 sesõoes por semana
        [14, 18, 22],
        [19],
        [19],
        [19],
        [21],
        [21],
        [13, 16, 19, 22],
    ];
    private $customers = [];
    private $movies = [];
    private $quantidades = [1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 4, 5, 5, 5, 6, 6, 6, 7, 7, 8, 8, 9, 9, 10, 10];
    private $faker = null;
    private $start_date;
    private $end_date;


    public function run()
    {
        $this->faker = \Faker\Factory::create(DatabaseSeeder::$seedLanguage);
        $this->command->info("Screenings e tickets");

        $today = Carbon::today();


        // CHANGE - INCREMENTAL
        $this->start_date = $today->copy();
        $this->start_date->subYears($this->numberOfYears);

        $d = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date->year . "-1-1 00:00:00");
        $largestOldSessionId = -1;
        if (DatabaseSeeder::$seedType == 'incremental') {
            if (Storage::exists('seed_info.log')) {
                $this->command->info('SEED EXISTE');
                $date =  Storage::get('seed_info.log');
                $date = Carbon::createFromFormat('Y-m-d H:i:s',  trim($date));
            } else {
                $date = DB::table('screenings')->max('date');
                $date = Carbon::createFromFormat('Y-m-d H:i:s',  trim($date) . ' 0:00:00');
            }
            $date->subDays($this->numberOfDaysAfterToday);
            $d = $date->copy();
            $this->command->info("Rebuild screenings, tickets and purchases from date: " . $d->format('Y-m-d'));
            $this->prepareIncremental($date);
            TheatersSeeder::fillTheatersInfo();
            $this->fillSeats();
            $largestOldSessionId = DB::table('screenings')->max('id');
        }

        $this->end_date = $today->copy();
        $this->end_date->addDays($this->numberOfDaysAfterToday);
        $i = 0;

        $this->criarPastaPurchases();
        $this->criarPastaTicketsQRCode();
        $this->fillCustomers();
        $this->fillSeats();
        $this->rebuildListOfMovies();

        // Generate All Sessions:
        $theaters_IDs = array_keys(TheatersSeeder::$theaters);
        $screeningToSave = [];
        $moviesTheaters = null;

        while ($d->lessThanOrEqualTo($this->end_date)) {
            $moviesTheaters = $this->distribui_movies_theaters($moviesTheaters);
            $screening = $this->schedulesScreening[$d->dayOfWeek];
            foreach ($screening as $screening) {
                foreach ($theaters_IDs as $theaterId) {
                    $screeningToSave[] = $this->createScreeningArray($moviesTheaters[$theaterId][0], $theaterId, $d, $screening);
                    $moviesTheaters[$theaterId][1]--;
                }
            }
            if ($i % 100 == 0) { /// 100 em 100 dias grava as screenings
                $this->command->info("Inserting screenings for date  " . $d->toDateString());
                DB::table('screenings')->insert($screeningToSave);
                $screeningToSave = [];
            }
            $i++;
            $d->addDays(1);
        }
        // Guarda as screenings restantes
        if (count($screeningToSave) > 1) {
            $this->command->info("Inserting screenings until date " . $d->toDateString());
            DB::table('screenings')->insert($screeningToSave);
            $screeningToSave = [];
        }

        // Apaga as screenings da theater soft_deleted depois de uma determinada data:
        $dateRef = $this->end_date->copy();
        $dateRef->subDays(200);
        $this->command->info("Vai apagar screenings da theater 5 (softdeleted) depois da data " . $dateRef->toDateString());
        DB::table('screenings')
            ->where('theater_id', 5)
            ->where('date', '>', $dateRef)
            ->delete();
        $this->command->info("Screenings da theater 5 (softdeleted) apagados ");

        $screening = DB::table('screenings')->where('id', '>', $largestOldSessionId)->get();
        $totalScreening = $screening->count();

        $i = 0;
        $comprasToSave = [];
        foreach ($screening as $screening) {
            $this->createAndSavePurchasesForScreening($screening);
            if ($i % 100 == 0) { /// 100 em 100 screening mostra uma mensage
                $this->command->info("Created and saved purchases and tickets for screening $i/$totalScreening");
            }
            if ($i % 1000 == 0) { /// 500 em 500 screening atualiza a percentagem ocupação
                $this->avgTaxaOcupacao = $this->avgTaxaOcupacao - rand(1, 3) + rand(1, 4);
                $this->avgTaxaOcupacao = $this->avgTaxaOcupacao < 5 ? 5 : $this->avgTaxaOcupacao;
                $this->avgTaxaOcupacao = $this->avgTaxaOcupacao > 80 ? 80 : $this->avgTaxaOcupacao;
                $this->command->info("Nova taxa de ocupação média = $this->avgTaxaOcupacao");
            }
            $i++;
        }
        $this->command->info("Created and saved purchases and tickets for screening $i/$totalScreening");

        $totalTicketsVendidos = DB::table('tickets')->count();
        $this->command->info("Total tickets sold = $totalTicketsVendidos");
        Storage::put('seed_info.log', $this->end_date->format('Y-m-d H:i:s'));
    }

    private function prepareIncremental($date)
    {
        $screening_to_delete = DB::table('screenings')->where('date', '>=', $date)->pluck('id')->toArray();
        DB::table('tickets')->whereIntegerInRaw('screening_id', $screening_to_delete)->delete();
        DB::table('screenings')->whereIntegerInRaw('id', $screening_to_delete)->delete();
        DB::delete('delete from purchases where id not in (select purchase_id from tickets)');
    }


    private function fillCustomers()
    {
        $this->customers = DB::table('customers')
            ->select(DB::raw('customers.id, customers.nif, customers.payment_type, customers.payment_ref, users.name, users.email'))
            ->join('users', 'customers.id', '=', 'users.id')
            ->get()
            ->toArray();
    }

    private function fillSeats()
    {
        $theaters_IDs = array_keys(TheatersSeeder::$theaters);
        foreach ($theaters_IDs as $theaterId) {
            $this->seats[$theaterId] = DB::table('seats')->select('id')->where('theater_id', $theaterId)->pluck('id')->toArray();
        }
    }

    private function shuffleSeats($theater = null)
    {
        $theaters_IDs = array_keys(TheatersSeeder::$theaters);
        if ($theater == null) {
            foreach ($theaters_IDs as $theaterId) {
                $this->seats[$theaterId] = Arr::shuffle($this->seats[$theaterId]);
            }
        } else {
            $this->seats[$theater] = Arr::shuffle($this->seats[$theater]);
        }
    }

    private function shuffleCustomers()
    {
        $this->customers = Arr::shuffle($this->customers);
    }

    private function fillMovies()
    {
        $idsMoviesUsed = DB::table('screenings')->select('movie_id')->distinct()->pluck('movie_id')->toArray();
        if (empty($idsMoviesUsed)) {
            $this->movies = DB::table('movies')->select('id')->pluck('id')->toArray();
        } else {
            $this->movies = DB::table('movies')->select('id')->whereNotIn('id', $idsMoviesUsed)->pluck('id')->toArray();
            if (empty($this->movies) || (count($this->movies) < 20)) {
                $this->movies = DB::table('movies')->select('id')->pluck('id')->toArray();
            }
        }
    }

    private function shuffleMovies()
    {
        $this->movies = Arr::shuffle($this->movies);
    }

    private function rebuildListOfMovies()
    {
        $this->command->info("Rebuilding list of movies");
        $this->fillMovies();
        $this->shuffleMovies();
    }

    private function distribui_movies_theaters($theatersMovies)
    {
        if (count($this->movies) == 0) {
            $this->rebuildListOfMovies();
        }
        if (!is_array($theatersMovies)) {
            $theatersMovies = [
                1 => [null, 0],
                2 => [null, 0],
                3 => [null, 0],
                4 => [null, 0],
                5 => [null, 0],
                6 => [null, 0],
                7 => [null, 0],
                8 => [null, 0],
            ];
        }
        foreach ($theatersMovies as $key => $theaterMovie) {
            if ($theaterMovie[1] <= 0) { // Screenings desse movie acabaram. Passa a outro movie
                $totalScreening = $this->numberOfAvgSessionPerMovie - rand(1, $this->deltaSessionPerMovieDown) + rand(1, $this->deltaSessionPerMovieUp);

                $removedMovie = array_shift($this->movies);
                if (count($this->movies) == 0) {
                    $this->rebuildListOfMovies();
                }
                $theatersMovies[$key] = [$removedMovie, $totalScreening];
                //$this->command->info("aleatorio (theater = $key) = movie: " . $theatersMovies[$key][0]. " total = " . $theatersMovies[$key][1]);
            }
        }
        return $theatersMovies;
    }

    private function createScreeningArray($movie, $theater, $date, $hora)
    {
        $inicio = $date->copy()->subDays(8)->addSeconds(rand(39600, 78000));
        $fim = $inicio->copy()->subDays(7)->addSeconds(rand(60, 300000));
        return [
            'movie_id' => $movie,
            'theater_id' => $theater,
            'date' => $date->toDateString(),
            'start_time' => $hora . ":00:00",
            'created_at' => $inicio,
            'updated_at' => $fim,
        ];
    }

    private function createAndSavePurchasesForScreening($screening)
    {
        $this->shuffleSeats($screening->theater_id);
        $d = Carbon::createFromFormat('Y-m-d', $screening->date);
        $diaSemana = $d->dayOfWeek;
        if (($diaSemana == 0) || ($diaSemana == 6)) {
            $factor = 1.1;
        } else {
            $factor = 0.3;
        }
        $taxa = ($this->avgTaxaOcupacao + rand(1, 20) + rand(1, 20)) * $factor;
        $totalSeats = TheatersSeeder::$theaters[$screening->theater_id];
        $totalTickets = round($totalSeats * $taxa / 100, 0);
        $totalTickets = min($totalTickets, $totalSeats);
        $totalTickets = max($totalTickets, 0);

        $arrayCompras = [];
        $idxSeat = 0;
        while ($totalTickets > 0) {
            $customer = rand(1,20) < 17 ? null : $this->faker->randomElement($this->customers);
            $qtdTickets = $this->faker->randomElement($this->quantidades);
            $qtdTickets = $qtdTickets > $totalTickets ? $totalTickets : $qtdTickets;
            $totalTickets -= $qtdTickets;
            $compraArray = $this->createCompraArray($screening, $customer, $qtdTickets, $idxSeat);
            $arrayCompras[] = $compraArray;
        }
        $this->saveCompras($arrayCompras);
    }

    private function createCompraArray($screening, $customer, $numTickets, &$idxSeat)
    {
        if ($customer) {
            $customer_id = $customer->id;
            $nif = $customer->nif;
            $customer_name = $customer->name;
            $customer_email = $customer->email;
            $payment_type = $customer->payment_type ?: 'MBWAY';
            $payment_ref = $customer->payment_ref ?: '9' . $this->faker->randomNumber($nbDigits = 8, $strict = true);
            $precoTicket = 8.0;
        } else {
            $fullname = '';
            $email = '';
            $gender = '';
            $payment_type = null;
            $payment_ref = null;
            UsersSeeder::randomName($this->faker, $gender, $fullname, $email, true);
            UsersSeeder::randomPaymentInfo($this->faker, $email, $payment_type, $payment_ref);
            $customer_id = null;
            $nif = rand(1,3) == 2 ? null : $this->faker->randomNumber($nbDigits = 9, $strict = true);
            $customer_name = $fullname;
            $customer_email = $email;
            $precoTicket = 9.0;
        }
        $d = Carbon::createFromFormat('Y-m-d', $screening->date);
        $d->subDays(rand(1, 7))->addSeconds(rand(60, 780000));
        $precoTotal =  round($numTickets * $precoTicket, 2);
        $updated = $d->copy()->addSeconds(rand(60, 300000));
        $tickets = [];
        for ($i = 0; $i < $numTickets; $i++) {
            if ($idxSeat >= count($this->seats[$screening->theater_id])) {
                break;
            }
            $tickets[] = [
                'purchase_id' => null,
                'screening_id' => $screening->id,
                'seat_id' => $this->seats[$screening->theater_id][$idxSeat],
                'price' => $precoTicket,
                // 1 em cada 15 bilhetes não são usados (ficam invalidos)
                'status' => $screening->date > Carbon::now() ? 'valid' : 'invalid'
            ];
            $idxSeat++;
        }
        if (count($tickets) == 0) {
            return [];
        }
        return [
            'customer_id' => $customer_id,
            'date' => $d->toDateString(),
            'total_price' => $precoTotal,
            'nif' => $nif,
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'payment_type' => $payment_type,
            'payment_ref' => $payment_ref,
            'receipt_pdf_filename' => null,
            'created_at' => $d,
            'updated_at' => $updated,
            'tickets' => $tickets
        ];
    }

    private function criarPastaTicketsQRCode()
    {
        Storage::deleteDirectory('ticket_qrcodes');
        Storage::makeDirectory('ticket_qrcodes');
    }

    private function criarPastaPurchases()
    {
        Storage::deleteDirectory('pdf_purchases');
        Storage::makeDirectory('pdf_purchases');
    }


    private function saveCompras($comprasToSave)
    {
        foreach ($comprasToSave as $compraToSave) {
            DB::transaction(function () use ($compraToSave) {
                $arrayCompra = Arr::except($compraToSave, ['tickets']);
                $idPurchase = DB::table('purchases')->insertGetId($arrayCompra);
                foreach ($compraToSave['tickets'] as $key => $value) {
                    $compraToSave['tickets'][$key]['purchase_id'] = $idPurchase;
                }
                DB::table('tickets')->insert($compraToSave['tickets']);
            });
        }
    }
}
