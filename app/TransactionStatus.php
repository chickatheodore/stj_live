<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property TransactionPoint[] $transactionPoints
 */
class TransactionStatus extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'transaction_status';

    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactionPoints()
    {
        return $this->hasMany('App\TransactionPoint', 'status_id');
    }
}
