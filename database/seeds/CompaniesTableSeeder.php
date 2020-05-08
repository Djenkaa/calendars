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
                'image'=>'https://cdn3.iconfinder.com/data/icons/capsocial-round/500/facebook-512.png'
            ],
            [
                'name'=>'Google',
                'image'=>'https://www.pngitem.com/pimgs/m/33-330202_google-logo-hd-png-download.png'
            ]
        ];

        Company::truncate();

        foreach ($companies as $company){

            Company::create($company);
        }
    }
}
