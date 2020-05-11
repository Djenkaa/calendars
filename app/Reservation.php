<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['fullName', 'email', 'phone', 'period', 'calendar_id', 'price'];


    /**
     * @var array
     */
    protected $guarded = ['id'];


    /**
     * @param $calendarId
     * @param $dates
     */
    public static function make($calendarId, $dates)
    {
        $calendar = Calendar::find($calendarId);
        $calendarDates = json_decode($calendar['dates'], true);

        foreach ($calendarDates as $key=>$value) {

            if(in_array($value['field'], $dates)){

                $calendarDates[$key]['type']['status'] = 'reserved';
                $calendarDates[$key]['type']['background'] = 'rgba(255, 71, 71,0.4)';
            }
        }
        $calendar['dates'] = json_encode($calendarDates);
        $calendar->save();
    }


    /**
     * @param $dates
     * @param $calendarId
     * @return int
     */
    public static function price($dates, $calendarId)
    {
        $calendar = Calendar::find($calendarId);

        $calendarDates = json_decode($calendar['dates'], true);
        $price = 0;

        foreach ($calendarDates as $date){

            if(in_array($date['field'], $dates)){

               $price+= (float) $date['type']['price'];
            }
        }
        return $price;
    }


    /**
     * @param $dates
     * @param $calendarId
     * @return bool
     */
    public static function freeDates($dates, $calendarId)
    {
        $calendar = Calendar::find($calendarId);
        $calendarDates = json_decode($calendar['dates'], true);

        foreach ($calendarDates as $date){

            if($date['type']['status'] == 'reserved' || $date['type']['status'] == 'unavailable'){

                if(in_array($date['field'], $dates)){
                    return false;
                }
            }
        }
        return true;
    }
}
