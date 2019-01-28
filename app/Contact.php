<?php

namespace App;

use Moloquent;

class Contact extends Moloquent
{
    protected $connection = 'mongodb';
    protected $fillable = [
    	'name', 'phone', 'type', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
