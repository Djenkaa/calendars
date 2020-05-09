<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Company;
use App\Reservation;
use Illuminate\Http\Request;

class CompanyController extends Controller
{


    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $companies = Company::all();

//        $price = Reservation::price([1,2], 3);
//        dd($price);
        return view('company.index', compact('companies'));
    }


    public function welcome()
    {
        $companies = Company::has('calendars')->with('currentYear')->get();

        return view('welcome',compact('companies'));
    }





}
