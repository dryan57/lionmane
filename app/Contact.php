<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
            'first_name',
            'last_name',
            'nick_name',
            'dob',
            'gender',
            'image',
            'active'
        ];
    public function telephones()
    {
        return $this->hasMany('App\Telephone');
    }

    public function emails()
    {
        return $this->hasMany('App\Email');
    }
}
