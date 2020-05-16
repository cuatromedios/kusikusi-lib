<?php

namespace Kusikusi\Models;

use Illuminate\Database\Eloquent\Model;

class Authtoken extends Model
{
    protected $fillable = [];

    public function user () {
        return $this->belongsTo('Kusikusi\Models\User');
    }

    public function getKeyName()
    {
        return 'token';
    }
}
