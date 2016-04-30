<?php

use Illuminate\Database\Seeder;

class OfferTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new \DateTime();

        $past = clone $now;
        $past->modify('-5days');

        $future = clone $now;
        $future->modify('+30days');

        DB::table('nh_offer')->insert(
            [
                ['street' => 'Karlsplatz', 'streetnumber' => 1, 'streetnumberadditional' => null, 'zip' => '1234', 'city' => 'Wien', 'phone' => '01/123456789', 'email' => 'foo@bar.com', 'age_from' => null, 'age_to' => null, 'valid_from' => null, 'valid_until' => null, 'ngo_id' => 1],
                ['street' => 'Karlsplatz', 'streetnumber' => 2, 'streetnumberadditional' => null, 'zip' => '1234', 'city' => 'Wien', 'phone' => '01/123456789', 'email' => 'foo@bar.com', 'age_from' => 18, 'age_to' => 99, 'valid_from' => null, 'valid_until' => null, 'ngo_id' => 1],
                ['street' => 'Karlsplatz', 'streetnumber' => 3, 'streetnumberadditional' => null, 'zip' => '1234', 'city' => 'Wien', 'phone' => '01/123456789', 'email' => 'foo@bar.com', 'age_from' => null, 'age_to' => null, 'valid_from' => $now->format('Y-m-d'), 'valid_until' => $future->format('Y-m-d'), 'ngo_id' => 1],
                ['street' => 'Karlsplatz', 'streetnumber' => 4, 'streetnumberadditional' => null, 'zip' => '1234', 'city' => 'Wien', 'phone' => '01/123456789', 'email' => 'foo@bar.com', 'age_from' => 18, 'age_to' => 99, 'valid_from' => $now->format('Y-m-d'), 'valid_until' => $future->format('Y-m-d'), 'ngo_id' => 1],
                ['street' => 'Karlsplatz', 'streetnumber' => 5, 'streetnumberadditional' => null, 'zip' => '1234', 'city' => 'Wien', 'phone' => '01/123456789', 'email' => 'foo@bar.com', 'age_from' => null, 'age_to' => null, 'valid_from' => $past->format('Y-m-d'), 'valid_until' => $now->format('Y-m-d'), 'ngo_id' => 1],
                ['street' => 'Karlsplatz', 'streetnumber' => 6, 'streetnumberadditional' => null, 'zip' => '1234', 'city' => 'Wien', 'phone' => '01/123456789', 'email' => 'foo@bar.com', 'age_from' => null, 'age_to' => null, 'valid_from' => $past->format('Y-m-d'), 'valid_until' => $future->format('Y-m-d'), 'ngo_id' => 1],
            ]
        );

        DB::table('nh_offer_translation')->insert(
            [
                ['language_id' => 1, 'offer_id' => 1, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
                ['language_id' => 2, 'offer_id' => 1, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],

                ['language_id' => 1, 'offer_id' => 2, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
            ]
        );

        DB::table('nh_offer_filter')->insert(
            [
                ['filter_id' => 1, 'offer_id' => 1],
                ['filter_id' => 2, 'offer_id' => 1],
                ['filter_id' => 5, 'offer_id' => 1],
                ['filter_id' => 2, 'offer_id' => 2],
            ]
        );

        DB::table('nh_offer_category')->insert(
            [
                ['category_id' => 1, 'offer_id' => 1],
                ['category_id' => 3, 'offer_id' => 1],
                ['category_id' => 4, 'offer_id' => 2],
                ['category_id' => 1, 'offer_id' => 3],
                ['category_id' => 1, 'offer_id' => 4],
                ['category_id' => 1, 'offer_id' => 5],
                ['category_id' => 1, 'offer_id' => 6],
            ]
        );
    }
}
