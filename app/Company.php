<?php

namespace App;

use App\Calendar;
use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    protected $fillable = ['name', 'image'];

    protected $guarded = ['id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendars()
    {
        return $this->hasMany(Calendar::class,'company_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function currentYear()
    {
        return $this->calendars()->where('year', now()->year)->orderBy('month', 'asc');
    }
}
