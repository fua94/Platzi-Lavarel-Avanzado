<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Carbon\Carbon;

class Rating extends Pivot
{
    public $incrementing = true;
    protected $table = "ratings";

    public function rateable()
    {
        return $this->morphTo();
    }

    public function qualifier()
    {
        return $this->morphTo();
    }

    public function approve()
    {
        $this->approved_at = Carbon::now();
    }
}
