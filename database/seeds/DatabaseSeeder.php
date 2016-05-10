<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguageTableSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(FilterTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(NgoSeeder::class);
        //$this->call(OfferTableSeeder::class);
    }
}
