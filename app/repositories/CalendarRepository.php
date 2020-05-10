<?php


namespace App\repositories;


use App\Calendar;
use App\Reservation;

class CalendarRepository
{


    /**
     * @param $dates
     * @param $calendarId
     * @return array
     */
    public function priceAndPeriod($dates, $calendarId)
    {
        $calendar = Calendar::find($calendarId);
        $datesNumber = count(json_decode($calendar['dates'], true));

        $period = $calendar->makePeriod($dates, $datesNumber);
        $price = Reservation::price($dates, $calendarId);

        return [$period, $price];
    }


    /**
     * @param $year
     * @param $month
     * @param $companyId
     * @return mixed
     */
    public function exist($year, $month, $companyId)
    {
        $calendar = Calendar::where([['year', $year],
            ['month', $month],
            ['company_id', $companyId]])
            ->first();

        return $calendar;
    }
}