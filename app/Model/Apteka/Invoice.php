<?php

namespace App\Model\Apteka;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'a_invoices';

    /**
     * @var array  fields to save
     */
    protected $fillable = [
        'title',
        'supplier_id',
        'price',
        'date',
        'description',
    ];

    /**
     * Get the product for the invoice.
     */
    public function products()
    {
        return $this->hasMany(Incoming::class);
    }
    /**
     * Get the supplier for the invoice.
     */
    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }
}
