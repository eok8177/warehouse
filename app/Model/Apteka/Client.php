<?php

namespace App\Model\Apteka;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'a_clients';

    /**
     * @var array  fields to save
     */
    protected $fillable = [
        'title',
        'name',
        'description',
    ];

    /**
     * Get the Products in the the Client.
     */
    public function outcoming()
    {
        return $this->hasMany(Outcoming::class, 'client_id', 'id');
    }
}
