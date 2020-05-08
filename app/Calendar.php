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

        $period = $min.'/'.$this->month.'/'.$this->year .' - '. $max.'/'.$this->month.'/'.$this->year;

        return $period;
    }
}
