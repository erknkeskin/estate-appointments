<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        factory(App\Model\Customer::class, 32)->create();
        factory(App\User::class, 8)->create();
        factory(App\Model\Office::class, 4)->create();
        factory(App\Model\Home::class, 15)->create();
        factory(App\Model\Appointment::class, 100)->create();
    }
}
