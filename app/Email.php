<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'contact_id',
        'email',
        'category'
    ];

    public function contact()
    {
        return $this->belongsTo('App\Contact');
    }
}
