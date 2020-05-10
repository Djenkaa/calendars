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
            'dates'=>json_encode($request->dates),
            'firstDay'=>$request->firstDay,
            'company_id'=>$request->companyId,
            'free'=>$request->free,
            'special'=>$request->special,
            'lastMinute'=>$request->lastMinute
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
        $datesNumber = count(json_decode($calendar['dates'],true));

        $period = $calendar->makePeriod($request->dates, $datesNumber);

        Reservation::create([
            'fullName'=>$request->fullName,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'period'=>$period,
            'calendar_id'=>$request->calendarId,
            'price'=>$request->price
        ]);

       Reservation::make($calendar->id, $request->dates);

       return response()->json('success');
    }


    /**
     * @param Request $request
     * @return array
     */
    public function price(Request $request)
    {
        $calendar = Calendar::find($request->calendarId);
        $datesNumber = count(json_decode($calendar['dates'],true));

        $period = $calendar->makePeriod($request->dates, $datesNumber);

        $price = Reservation::price($request->dates, $request->calendarId);

        $result = [
            'period'=>$period,
            'price'=>$price
        ];
        return $result;
    }
}
