<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['year', 'month', 'firstDay', 'dates', 'company_id', 'free', 'special', 'lastMinute'];


    /**
     * @var array
     */
    protected $guarded = ['id'];


    /**
     * Make period by dates
     *
     * @param $dates
     * @param $calendarDates
     * @return string
     */
    public function makePeriod($dates, $calendarDates)
    {
        $min = min($dates);
        $max = max($dates);

        $until = $max >= $calendarDates ? $max : $max + 1;
        $month = $this->month + 1;

        $period = $min . '/' . $month. '/' . $this->year . ' - ' . $until . '/' . $month . '/' . $this->year;

        return $period;
    }


}
