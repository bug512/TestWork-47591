<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\SiteCard;

class SiteCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteCard::factory(10)->create();
    }
}
