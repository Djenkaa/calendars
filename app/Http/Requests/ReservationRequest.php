<?php

namespace App\Http\Requests;

use App\Reservation;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fullName'=>'required|string|min:3|max:40',
            'email'=>'required|email',
            'phone'=>'required',
            'calendarId'=>'required|integer',
            'price'=>'required|numeric'
        ];
    }


    /**
     * Reservation
     * @param $period
     */
    public function persist($period)
    {
        $data = $this->only(['fullName', 'email', 'phone', 'calendarId', 'price', 'dates']);

        Reservation::create([
            'fullName'=>$data['fullName'],
            'email'=>$data['email'],
            'phone'=>$data['phone'],
            'period'=>$period,
            'calendar_id'=>$data['calendarId'],
            'price'=>$data['price']
        ]);

        Reservation::make($data['calendarId'], $data['dates']);
    }

}
