<?php


namespace App\repositories\interfaces;


interface CalendarRepositoryInterface
{

    /**
     * @param $dates
     * @param $calendarId
     * @return array
     */
    public function priceAndPeriod($dates, $calendarId);


    /**
     * @param $year
     * @param $month
     * @param $companyId
     * @return mixed
     */
    public function exist($year, $month, $companyId);
}