<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $member_id
 * @property int $user_id
 * @property int $status_id
 * @property string $transaction_date
 * @property string $trans
 * @property float $left_amount
 * @property float $right_amount
 * @property float $left_beginning_balance
 * @property float $right_beginning_balance
 * @property float $income
 * @property float $expense
 * @property float $left_ending_balance
 * @property float $right_ending_balance
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Member $member
 * @property TransactionStatus $transactionStatus
 * @property Member $reference
 */
class TransactionPoint extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction_point';

    /**
     * @var array
     */
    protected $fillable = ['member_id', 'user_id', 'status_id', 'transaction_date', 'trans',
        'left_amount', 'right_amount', 'left_beginning_balance', 'right_beginning_balance',
        'income', 'expense', 'left_ending_balance', 'right_ending_balance',
        'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return BelongsTo
     */
    public function member()
    {
        return $this->belongsTo('App\Member');
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
    public function reference()
    {
        return $this->belongsTo('App\Member', 'user_id');
    }
}
