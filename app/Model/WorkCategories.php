<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkCategories extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'work_categories';

    /**
     * @var array  fields to save
     */
    protected $fillable = [
        'name',
        'description',
    ];
}
