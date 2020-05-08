<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Reservation;
use Illuminate\Http\Request;

class CalendarController extends Controller
{


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Calendar::create([
            'year'=>$request->year,
            'month'=>$request->month,
            'dates'=>json_encode($request->dates,),
            'firstDay'=>$request->firstDay,
            'company_id'=>$request->companyId
        ]);

        return response()->json('success');
    }


    /**
     * @param Calendar $calendar
     * @return Calendar
     */
    public function show(Calendar $calendar)
    {
        return $calendar;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reserve(Request $request)
    {
        $calendar = Calendar::find($request->calendarId);
        $period = $calendar->makePeriod($request->dates);

        Reservation::create([
            'fullName'=>$request->fullName,
            'email'=>'mirko@gmail.com',
            'phone'=>$request->phone,
            'period'=>$period
        ]);

       Reservation::make($calendar->id, $request->dates);

       return response()->json('success');
    }
}
