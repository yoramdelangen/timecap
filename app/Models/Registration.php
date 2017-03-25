<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'decorator', 'register_value', 'title', 'registered_on'];

    protected $casts = [
        'user_id'        => 'integer',
        'register_value' => 'integer',
    ];
    // @TODO: registered_on with tz
    protected $dates = ['registered_on'];
}
