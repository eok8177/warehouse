<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'works';

    /**
     * @var array  fields to save
     */
    protected $fillable = [
        'lpz_id',
        'cat_id',
        'invoice',
        'summ',
        'description',
    ];

    /**
     * Get the Lpz that owns the Work.
     */
    public function lpz()
    {
        return $this->belongsTo(Lpz::class);
    }

    /**
     * Get the Category that owns the Work.
     */
    public function cat()
    {
        return $this->belongsTo(WorkCategories::class);
    }
}
