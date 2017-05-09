<?php

namespace App\Model\Apteka;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'a_products';

    /**
     * @var array  fields to save
     */
    protected $fillable = [
        'bill_id',
        'invoice_id',
        'title',
        'measure',
        'quantity',
        'sum',
        'description',
    ];

    /**
     * Get the Bill that owns the Product.
     */
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    /**
     * Get the Incoming in the the Product.
     */
    public function incoming()
    {
        return $this->hasMany(Incoming::class);
    }

    /**
     * Get the Outcoming in the the Product.
     */
    public function outcoming()
    {
        return $this->hasMany(Outcoming::class);
    }
}
