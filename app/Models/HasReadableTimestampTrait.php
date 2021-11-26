<?php

namespace App\Models;

use Carbon\Carbon;

trait HasReadableTimestampTrait
{
    /**
     * @inheritDoc
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimeStamp(strtotime($value))->diffForHumans();
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::createFromTimeStamp(strtotime($value))->diffForHumans();
    }
}