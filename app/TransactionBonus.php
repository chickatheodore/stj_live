<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $member_id
 * @property float $bonus_partner
 * @property float $bonus_sponsor
 * @property float $bonus_paid
 * @property float $bonus_balance
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Member $member
 */
class TransactionBonus extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction_bonus';

    /**
     * @var array
     */
    protected $fillable = ['member_id', 'bonus_partner', 'bonus_sponsor', 'bonus_paid', 'bonus_balance', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return BelongsTo
     */
    public function member()
    {
        return $this->belongsTo('App\Member');
    }

}
