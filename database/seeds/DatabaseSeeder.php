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
        $this->call([
            ProvinceSeed::class,
            RegionSeed::class,
            CategorieSeed::class,
            filiereSeed::class,
            UserSeed::class,
        ]);
    }
}
