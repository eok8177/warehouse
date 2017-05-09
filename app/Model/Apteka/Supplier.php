<?php

namespace App\Model\Apteka;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'a_suppliers';

    /**
     * @var array  fields to save
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Get the Invoices in the the Client.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'supplier_id', 'id');
    }
}
