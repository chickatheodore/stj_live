<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $level_id
 * @property string $type
 * @property float $bonus
 * @property Level $level
 */
class Bonus extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'bonus';

    /**
     * @var array
     */
    protected $fillable = ['level_id', 'type', 'bonus'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo('App\Level');
    }
}
