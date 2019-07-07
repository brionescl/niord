<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User', 'bank_user');
    }
}
