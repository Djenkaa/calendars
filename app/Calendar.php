<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = ['year', 'month', 'firstDay', 'dates', 'company_id'];


    protected $guarded = ['id'];


    /**
     * Make period by dates
     *
     * @param $dates
     * @return string
     */
    public function makePeriod($dates)
    {
        $min = min($dates);
        $max = max($dates);
        $until = $max > count($dates) ? $max : $max + 1;

        $period = $min.'/'.$this->month.'/'.$this->year .' - '. $until.'/'.$this->month.'/'.$this->year;

        return $period;
    }


}
