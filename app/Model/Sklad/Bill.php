<?php

namespace App\Model\Sklad;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 's_bills';

    /**
     * @var array  fields to save
     */
    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Get the Products in the the Bill.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public static function forSelect()
    {
        $bils = array();
        foreach (Bill::all() as $bill) {
            $bils[$bill->id] = $bill->title . ' - ' . $bill->description;
        }
        return $bils;
    }
}
