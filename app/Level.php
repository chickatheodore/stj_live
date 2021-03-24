<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $minimum_point
 * @property float $point_value
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Bonus[] $bonuses
 * @property Member[] $members
 */
class Level extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'minimum_point', 'point_value', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return HasMany
     */
    public function bonuses()
    {
        return $this->hasMany('App\Bonus');
    }

    /**
     * @return HasMany
     */
    public function members()
    {
        return $this->hasMany('App\Member');
    }
}
