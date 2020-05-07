<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{


    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $companies = Company::all();

        return view('company.index', compact('companies'));
    }
}
