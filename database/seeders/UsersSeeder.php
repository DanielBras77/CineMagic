<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    private $photoPath = 'public/photos';

    private $typesOfUsers =  ['A', 'E', 'C'];
    private $numberOfUsers = [6, 15, 500];
    private $numberOfSoftDeletedUsers = [1, 3, 45];
    private $numberOfBlocked = [1, 3, 30];
    private $files_M = [];
    private $files_F = [];
    private $genres = [];

    public static $allUsers = [];
    public static $allCustomers = [];

    private static $used_emails = [];
    public static $hashPasword = "";


    public function run()
    {
        $this->command->table(['Users table seeder notice'], [
            ['Photos will be stored on path ' . storage_path('app/' . $this->photoPath)]
        ]);

        $this->cleanFilesPhotos();
        $this->preencherFileNamesPhotos();

        $faker = \Faker\Factory::create(DatabaseSeeder::$seedLanguage);

        $variosUsers = [];
        $totalGuardados = 0;
        $totalParaGuardar = 0;
        foreach ($this->typesOfUsers as $idxType => $typeUser) {
            $totalParaGuardar += $this->numberOfUsers[$idxType];
        }
        foreach ($this->typesOfUsers as $idxType => $typeUser) {
            $totalUsers = $this->numberOfUsers[$idxType];
            for ($i = 0; $i < $totalUsers; $i++) {
                $newUser = $this->newFakerUser($faker, $typeUser);
                $variosUsers[] = $newUser;
                if (count($variosUsers) >= 50) {
                    $totalGuardados += count($variosUsers);
                    $this->command->info("Saved $totalGuardados/$totalParaGuardar users on the database");
                    DB::table('users')->insert($variosUsers);
                    $variosUsers = [];
                }
            }
        }
        if (count($variosUsers) > 0) {
            $totalGuardados += count($variosUsers);
            $this->command->info("Saved $totalGuardados/$totalParaGuardar users on the database");
            DB::table('users')->insert($variosUsers);
        }
        UsersSeeder::$allUsers['A'] = DB::table('users')->where('type', 'A')->pluck('email', 'id');
        UsersSeeder::$allUsers['E'] = DB::table('users')->where('type', 'E')->pluck('email', 'id');
        UsersSeeder::$allUsers['C'] = DB::table('users')->where('type', 'C')->pluck('email', 'id');

        $this->fillGenders(UsersSeeder::$allUsers['A']);
        $this->fillGenders(UsersSeeder::$allUsers['E']);
        $this->fillGenders(UsersSeeder::$allUsers['C']);

        shuffle($this->files_M);
        shuffle($this->files_F);

        UsersSeeder::$allUsers['A'] = UsersSeeder::$allUsers['A']->shuffle();
        UsersSeeder::$allUsers['E'] = UsersSeeder::$allUsers['E']->shuffle();
        UsersSeeder::$allUsers['C'] = UsersSeeder::$allUsers['C']->shuffle();

        $this->copiarPhotos(UsersSeeder::$allUsers['A']);
        $this->copiarPhotos(UsersSeeder::$allUsers['E']);
        $this->copiarPhotos(UsersSeeder::$allUsers['C']);

        $idsToBlock = [];
        $idsToDelete = [];
        foreach ($this->typesOfUsers as $idxType => $typeUser) {
            $usersToBlock = $this->numberOfBlocked[$idxType];
            $usersToDelete = $this->numberOfSoftDeletedUsers[$idxType];
            foreach (UsersSeeder::$allUsers[$typeUser] as $user) {
                if ($usersToBlock > 0) {
                    $idsToBlock[] = $user['id'];
                    $usersToBlock--;
                } elseif (($usersToBlock == 0) && ($usersToDelete > 0)) {
                    $idsToDelete[] = $user['id'];
                    $usersToDelete--;
                }
                if (($usersToBlock == 0) && ($usersToDelete == 0)) {
                    continue;
                }
            }
        }

        if (count($idsToBlock) > 0) {
            $this->command->info("Block " . count($idsToBlock) . " users on the database");
            DB::table('users')->whereIn('id', $idsToBlock)->update(['blocked' => 1]);
        }
        if (count($idsToDelete) > 0) {
            $this->command->info("Soft Delete " . count($idsToDelete) . " users on the database");
            DB::table('users')->whereNotIn('id', $idsToDelete)->update(['deleted_at' => null]);
        }


        UsersSeeder::$allCustomers = DB::table('users')->where('type', 'C')->pluck('id', 'email');

        $totalGuardados = 0;
        $totalParaGuardar = UsersSeeder::$allCustomers->count();
        $array_customers = [];
        foreach (UsersSeeder::$allCustomers as $email => $id_customer) {
            $array_customers[] = $this->newFakerCustomer($faker, $id_customer, $email);
            if (count($array_customers) >= 50) {
                $totalGuardados += count($array_customers);
                $this->command->info("Saved $totalGuardados/$totalParaGuardar customers on the database");
                DB::table('customers')->insert($array_customers);
                $array_customers = [];
            }
        }
        if (count($array_customers) > 0) {
            $totalGuardados += count($array_customers);
            $this->command->info("Saved $totalGuardados/$totalParaGuardar customers on the database");
            DB::table('users')->insert($array_customers);
        }

        $this->command->info("Update timestamps of customers");
        DB::update("update customers as c inner join (
                        select id, created_at, updated_at, deleted_at
                        from users
                        ) as u on c.id = u.id
                    set c.created_at = u.created_at, c.updated_at = u.updated_at, c.deleted_at = u.deleted_at");

        $this->command->info("Update payment references of Paypal");
        DB::update("update customers as c
                    inner join (
                        select id, email
                        from users
                        ) as u on c.id = u.id
                    set c.payment_ref = u.email
                    where c.payment_type = 'PAYPAL'");

        $this->command->info("Update first Administrators, Employees and Customers with known email");
        $idsAdmins = DB::table('users')
            ->where('type', 'A')
            ->where('blocked', 0)
            ->whereNull('deleted_at')
            ->whereNotNull('photo_filename')
            ->orderBy('id')
            ->take(2)
            ->pluck('id');
        foreach ($idsAdmins as $key => $id) {
            $idx = $key + 1;
            DB::table('users')->where('id', $id)->update(['email' => "a$idx@mail.pt"]);
        }
        $idsEmployees = DB::table('users')
            ->where('type', 'E')
            ->where('blocked', 0)
            ->whereNull('deleted_at')
            ->whereNotNull('photo_filename')
            ->orderBy('id')
            ->take(2)
            ->pluck('id');
        foreach ($idsEmployees as $key => $id) {
            $idx = $key + 1;
            DB::table('users')->where('id', $id)->update(['email' => "e$idx@mail.pt"]);
        }
        $idsCustomers = DB::table('users')
        ->where('type', 'C')
            ->where('blocked', 0)
            ->whereNull('deleted_at')
            ->orderBy('id')
            ->take(4)
            ->pluck('id');
        foreach ($idsCustomers as $key => $id) {
            $idx = $key + 1;
            DB::table('users')->where('id', $id)->update(['email' => "c$idx@mail.pt"]);

            DB::table('customers')
                ->where('id', $id)
                ->where('payment_type', 'PAYPAL')
                ->update(['payment_ref' => "c$idx@mail.pt"]);
        }


    }

    private function fillGenders($users_array)
    {
        foreach ($users_array as $key => $value) {
            $users_array[$key] = [
                "id" => $key,
                "email" => $value,
                "genre" => $this->genres[$value]
            ];
        }
    }

    private function cleanFilesPhotos()
    {
        Storage::deleteDirectory($this->photoPath);
        Storage::makeDirectory($this->photoPath);
    }

    private function preencherFileNamesPhotos()
    {
        $allFiles = collect(File::files(database_path('seeders/photos')));
        foreach ($allFiles as $f) {
            if (strpos($f->getPathname(), 'm_')) {
                $this->files_M[] = $f->getPathname();
            } else {
                $this->files_F[] = $f->getPathname();
            }
        }
    }

    private function copiarPhotos($arrayUsers)
    {
        foreach ($arrayUsers as $user) {
            if ((count($this->files_M) == 0) && (count($this->files_F) == 0)) {
                break;
            }
            $file = $user['genre'] == 'M' ? array_shift($this->files_M) : array_shift($this->files_F);
            if ($file) {
                $this->savePhotoOfUser($user['id'], $file);
            }
        }
    }

    private function savePhotoOfUser($id, $file)
    {
        $targetDir = storage_path('app/' . $this->photoPath);
        $newfilename = $id . "_" . uniqid() . '.jpg';
        File::copy($file, $targetDir . '/' . $newfilename);
        DB::table('users')->where('id', $id)->update(['photo_filename' => $newfilename]);
        $this->command->info("Atualizada photo do user $id. Name do file copiado = $newfilename");
    }

    private static function stripAccents($stripAccents)
    {
        $from = 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ';
        $to =   'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY';
        $keys = array();
        $values = array();
        preg_match_all('/./u', $from, $keys);
        preg_match_all('/./u', $to, $values);
        $mapping = array_combine($keys[0], $values[0]);
        return strtr($stripAccents, $mapping);
    }

    private function strtr_utf8($str, $from, $to)
    {
        $keys = array();
        $values = array();
        preg_match_all('/./u', $from, $keys);
        preg_match_all('/./u', $to, $values);
        $mapping = array_combine($keys[0], $values[0]);
        return strtr($str, $mapping);
    }

    public static function randomName($faker, &$gender, &$fullname, &$email, $allowRepeated = false)
    {
        $gender = $faker->randomElement(['male', 'female']);
        $firstname = $faker->firstName($gender);
        $lastname = $faker->lastName();
        $secondname = $faker->numberBetween(1, 3) == 2 ? "" : " " . $faker->firstName($gender);
        $number_middlenames = $faker->numberBetween(1, 6);
        $number_middlenames = $number_middlenames == 1 ? 0 : ($number_middlenames >= 5 ? $number_middlenames - 3 : 1);
        $middlenames = "";
        for ($i = 0; $i < $number_middlenames; $i++) {
            $middlenames .= " " . $faker->lastName();
        }
        $fullname = $firstname . $secondname . $middlenames . " " . $lastname;
        $email = strtolower(self::stripAccents($firstname) . "." . self::stripAccents($lastname) . "@mail.pt");
        if (!$allowRepeated) {
            $i = 2;
            while (in_array($email, self::$used_emails)) {
                $email = strtolower(self::stripAccents($firstname) . "." . self::stripAccents($lastname) . "." . $i . "@mail.pt");
                $i++;
            }
        }
        self::$used_emails[] = $email;
        $gender = $gender == 'male' ? 'M' : 'F';
    }

    private function newFakerUser($faker, $type)
    {
        $fullname = "";
        $email = "";
        $gender = "";
        self::randomName($faker, $gender, $fullname, $email);
        $createdAt = $faker->dateTimeBetween('-10 years', '-3 months');
        $email_verified_at = $faker->dateTimeBetween($createdAt, '-2 months');
        $updatedAt = $faker->dateTimeBetween($email_verified_at, '-1 months');
        $deletedAt = $faker->dateTimeBetween($updatedAt);
        $this->genres[$email] = $gender;
        if (self::$hashPasword == "") {
            self::$hashPasword = bcrypt('123');
        }
        return [
            'name' => $fullname,
            'email' => $email,
            'email_verified_at' => $email_verified_at,
            'password' => self::$hashPasword,
            'remember_token' => Str::random(10),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
            'type' => $type,
            'blocked' => 0,
            'deleted_at' => $deletedAt,
        ];
    }

    public static function randomPaymentInfo($faker, $email, &$paymentType, &$paymentReference)
    {
        $paymentType = $faker->randomElement(['VISA', 'MBWAY', 'PAYPAL']);
        switch ($paymentType) {
            case 'VISA':
                $paymentReference = rand(4, 6) . $faker->randomNumber($nbDigits = 8, $strict = true) . $faker->randomNumber($nbDigits = 7, $strict = true);
                break;
            case 'MBWAY':
                $paymentReference = '9' . $faker->randomNumber($nbDigits = 8, $strict = true);
                break;
            case 'PAYPAL':
                $paymentReference = $email;
                break;
        }
    }

    private function newFakerCustomer($faker, $id, $email)
    {
        $paymentType = null;
        $paymentRef = null;
        $hasPayment = rand(1, 5) != 3;
        if ($hasPayment) {
            self::randomPaymentInfo($faker, $email, $paymentType, $paymentRef);
        }
        return [
            'id' => $id,
            'nif' => rand(1,3) == 2 ? null : $faker->randomNumber($nbDigits = 9, $strict = true),
            'payment_type' => $paymentType,
            'payment_ref' => $paymentRef,
            'created_at' => null,
            'updated_at' => null,
            'deleted_at' => null
        ];
    }
}
