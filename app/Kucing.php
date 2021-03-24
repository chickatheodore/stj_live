<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $kucing_id
 * @property string $ikan_asin
 */
class Kucing extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'kucing';

    /**
     * @var array
     */
    protected $fillable = ['kucing_id', 'ikan_asin'];

}
