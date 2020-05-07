<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'name'=>'Facebook',
                'image'=>'https://miro.medium.com/max/900/1*2c4oE4vKaS4nlcDQ52UGqg.png'
            ],
            [
                'name'=>'Google',
                'image'=>'https://www.impossible.sg/wp-content/uploads/2013/12/google-hummingbird-explained.jpg'
            ]
        ];

        Company::truncate();

        foreach ($companies as $company){

            Company::create($company);
        }
    }
}
