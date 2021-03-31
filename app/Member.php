<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kalnoy\Nestedset\NodeTrait;
use Laravel\Passport\HasApiTokens;

/**
 * @property int $id
 * @property int $city_id
 * @property int $province_id
 * @property int $country_id
 * @property int $level_id
 * @property int $sponsor_id
 * @property int $upline_id
 * @property string $code
 * @property string $username
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $nik
 * @property string $address
 * @property string $phone
 * @property string $postal_code
 * @property string $bank
 * @property string $account_number
 * @property string $account_name
 * @property int $left_downline_id
 * @property int $right_downline_id
 * @property int $pin
 * @property float $left_point
 * @property float $left_bonus_point
 * @property float $left_bonus_partner
 * @property float $right_point
 * @property float $right_bonus_point
 * @property float $right_bonus_partner
 * @property float $point_bonus
 * @property float $sponsor_bonus
 * @property float $partner_bonus
 * @property string $activation_date
 * @property string $close_point_date
 * @property string $remember_token
 * @property int $tree_level
 * @property string $tree_position
 * @property int $left_downline_count
 * @property int $right_downline_count
 * @property bool $is_stockiest
 * @property bool $is_new_member
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property City $city
 * @property Country $country
 * @property Level $level
 * @property Province $province
 * @property Member $sponsor
 * @property Member $upLine
 * @property TransactionPoint[] $myInternalTransactions
 * @property TransactionPoint[] $myExternalTransactions
 */
class Member extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, NodeTrait;

    /**
     * @var string
     */
    protected $guard = 'member';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'city_id', 'province_id', 'country_id', 'level_id', 'sponsor_id', 'upline_id', 'code', 'username', 'name', 'email', 'password',
        'nik', 'address', 'phone', 'postal_code', 'bank', 'account_number', 'account_name', 'left_downline_id', 'right_downline_id', 'pin',
        'left_point', 'left_bonus_point', 'left_bonus_partner', 'right_point', 'right_bonus_point', 'right_bonus_partner', 'sponsor_bonus',
        'activation_date', 'close_point_date',
        'remember_token', 'tree_level', 'left_downline_count', 'right_downline_count', 'is_stockiest', 'created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    //protected $with = array('leftDownLine', 'rightDownLine');

    /**
     * @return BelongsTo
     */
    public function city()
    {
        return $this->belongsTo('App\City');
    }

    /**
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    /**
     * @return BelongsTo
     */
    public function level()
    {
        return $this->belongsTo('App\Level');
    }

    /**
     * @return BelongsTo
     */
    public function province()
    {
        return $this->belongsTo('App\Province');
    }

    /**
     * @return BelongsTo
     */
    public function sponsor()
    {
        return $this->belongsTo('App\Member', 'sponsor_id');
    }

    /**
     * @return BelongsTo
     */
    public function upLine()
    {
        return $this->belongsTo('App\Member', 'upline_id');
    }

    /**
     * @return hasOne
     */
    public function leftDownLine() {
        return $this->hasOne('App\Member', 'id', 'left_downline_id');
    }

    /**
     * @return hasOne
     */
    public function rightDownLine() {
        return $this->hasOne('App\Member', 'id', 'right_downline_id');
    }

    /**
     * @return HasMany
     */
    public function myInternalTransactions()
    {
        return $this->hasMany('App\TransactionPoint');
    }

    /**
     * @return HasMany
     */
    public function myExternalTransactions()
    {
        return $this->hasMany('App\TransactionPoint', 'user_id');
    }

    protected $ikan = '';
    public function getIkanAttribute()
    {
        return $this->ikan;
    }
    public function setIkanAttribute($value)
    {
        $this->ikan = $value;
    }

    /*
     * Baru - untuk mengakomodasi NodeSet
     */
    public function getLftName()
    {
        return 'left_downline_id';
    }

    public function getRgtName()
    {
        return 'right_downline_id';
    }

    public function getParentIdName()
    {
        return 'upline_id';
    }

    // Specify parent id attribute mutator
    public function setParentAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }}
