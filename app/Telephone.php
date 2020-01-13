<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telephone extends Model
{
        protected $fillable = [
            'contact_id',
            'phone_number',
            'category'
        ];

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }
}
