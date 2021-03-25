<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $member_id
 * @property int $user_id
 * @property int $status_id
 * @property string $transaction_date
 * @property string $type
 * @property string $trans
 * @property float $pin_beginning_balance
 * @property float $pin_amount
 * @property float $pin_ending_balance
 * @property float $left_point_beginning_balance
 * @property float $right_point_beginning_balance
 * @property float $left_point_amount
 * @property float $right_point_amount
 * @property float $left_point_ending_balance
 * @property float $right_point_ending_balance
 * @property float $bonus_beginning_balance
 * @property float $bonus_point_amount
 * @property float $bonus_sponsor_amount
 * @property float $bonus_paid_amount
 * @property float $bonus_ending_balance
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Member $member
 * @property TransactionStatus $transactionStatus
 * @property Member $user
 */
class Transaction extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['member_id', 'user_id', 'status_id', 'transaction_date', 'type', 'trans', 'pin_beginning_balance', 'pin_amount', 'pin_ending_balance', 'left_point_beginning_balance', 'right_point_beginning_balance', 'left_point_amount', 'right_point_amount', 'left_point_ending_balance', 'right_point_ending_balance', 'bonus_beginning_balance', 'bonus_point_amount', 'bonus_sponsor_amount', 'bonus_paid_amount', 'bonus_ending_balance', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return BelongsTo
     */
    public function member()
    {
        return $this->belongsTo('App\Member', 'member_id');
    }

    /**
     * @return BelongsTo
     */
    public function transactionStatus()
    {
        return $this->belongsTo('App\TransactionStatus', 'status_id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Member', 'user_id');
    }
}
