<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function province()
    {
        return $this->belongsTo('App\Province', 'province_id');
    }
}
