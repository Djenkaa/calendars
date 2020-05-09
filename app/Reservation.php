<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['fullName', 'email', 'phone', 'period'];


    protected $guarded = ['id'];


    public static function make($calendarId, $dates)
    {
        $calendar = Calendar::find($calendarId);
        $calendarDates = json_decode($calendar['dates'], true);

        foreach ($calendarDates as $key=>$value) {

            if(in_array($value['field'], $dates)){

                $calendarDates[$key]['type']['status'] = 'busy';
                $calendarDates[$key]['type']['background'] = 'rgba(255, 71, 71,0.4)';
            }
        }
        $calendar['dates'] = json_encode($calendarDates);
        $calendar->save();
    }
}
