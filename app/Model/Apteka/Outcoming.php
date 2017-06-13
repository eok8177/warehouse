<?php

namespace App\Model\Apteka;

use Illuminate\Database\Eloquent\Model;

class Outcoming extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'a_outcoming';

    /**
     * @var array  fields to save
     */
    protected $fillable = [
        'client_id',
        'product_id',
        'incoming_id',
        'count',
        'sum',
        'date',
        'description',
    ];

    /**
     * Get the client for the outcoming.
     */
    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    /**
     * Get the product for the outcoming.
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    /**
     * Get the incoming for the outcoming.
     */
    public function incoming()
    {
        return $this->hasOne(Incoming::class, 'id', 'incoming_id');
    }
}
