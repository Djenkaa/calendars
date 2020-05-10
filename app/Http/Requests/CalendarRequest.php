<?php

namespace App\Http\Requests;

use App\Calendar;
use Illuminate\Foundation\Http\FormRequest;

class CalendarRequest extends FormRequest
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
            'year'=>'required|integer',
            'month'=>'required|integer',
            'dates'=>'required',
            'firstDay'=>'required|integer',
            'companyId'=>'required|integer',
            'free'=>'required|integer',
            'special'=>'integer',
            'lastMinute'=>'integer'
        ];
    }


    /**
     * Create calendar
     */
    public function persist()
    {
        $data = $this->only(['year', 'month', 'dates', 'firstDay', 'companyId', 'free', 'special', 'lastMinute']);

        Calendar::create([
            'year'=>$data['year'],
            'month'=>$data['month'],
            'dates'=>json_encode($data['dates']),
            'firstDay'=>$data['firstDay'],
            'company_id'=>$data['companyId'],
            'free'=>$data['free'],
            'special'=>$data['special'],
            'lastMinute'=>$data['lastMinute']
        ]);
    }
}
