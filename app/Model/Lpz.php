<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lpz extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lpz';

    /**
     * @var array  fields to save
     */
    protected $fillable = [
        'name',
        'description',
    ];
}
