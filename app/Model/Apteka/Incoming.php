<?php

namespace App\Model\Apteka;

use Illuminate\Database\Eloquent\Model;

class Incoming extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'a_incoming';

    /**
     * @var array  fields to save
     */
    protected $fillable = [
        'invoice_id',
        'product_id',
        'count',
        'price',
        'sum',
        'date',
        'description',
        'cert',
        'serial',
        'expire',
    ];

    /**
     * Get the invoice for the incoming.
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }

    /**
     * Get the product for the incoming.
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
