<?php

namespace Cuatromedios\Kusikusi\Models;

use Illuminate\Database\Eloquent\Model;

class Authtoken extends Model
{
    protected $fillable = [];

    public function user () {
        return $this->belongsTo('App\Models\User');
    }

    public function getKeyName()
    {
        return 'token';
    }
}
