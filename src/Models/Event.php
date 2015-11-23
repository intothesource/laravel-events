<?php

namespace IntoTheSource\Events\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'intro',
        'text',
        'streetname',
        'streetnumber',
        'postal',
        'city',
        'member_amount',
        'member_cost',
        'guest_amount',
        'guest_cost',
        'started_at',
        'ended_at',
    ];

    /**
    * Additional field to treat as Carbon instances.
    *
    * @var array
    */
    protected $dates = ['started_at', 'ended_at'];

    /**
    * Set the publisched at date with the time of 0:00.
    *
    * @param $date
    * @return string
    */
    public function setStartedAtAttribute($date)
    {
        $this->attributes['started_at'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    /**
    * Set the publisched at date with the time of 0:00.
    *
    * @param $date
    * @return string
    */
    public function setEndedAtAttribute($date)
    {
        $this->attributes['ended_at'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    /**
    * Get the articles that are published.
    *
    * @param $query
    */
    public function scopeStarted($query)
    {
        $query->where('started_at', '<=', Carbon::now())->where('ended_at', '>', Carbon::now());
        return $query;
    }

    /**
    * Get the articles that are not published yet.
    *
    * @param $query
    */
    public function scopeNotStarted($query)
    {
        $query->where('started_at', '>', Carbon::now());
        return $query;
    }

    /**
    * Get the articles that are published.
    *
    * @param $query
    */
    public function scopeEnded($query)
    {
        $query->where('started_at', '<=', Carbon::now())->where('ended_at', '<=', Carbon::now());
        return $query;
    }
}
