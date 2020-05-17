<?php

namespace Kusikusi\Models;

use Illuminate\Database\Eloquent\Model;
use Kusikusi\Models\Traits\UsesShortId;

class Route extends Model
{
    use UsesShortId;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'route_id', 'entity_id', 'entity_model'];
    protected $fillable = ['entity_id', 'path', 'entity_model', 'lang', 'default'];
    protected $casts = [
        'default' => 'boolean'
    ];
    /**
     * To avoid "ambiguous" SQL errors Change the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'route_id';
    }
    public function entity () {
        return $this->belongsTo('Kusikusi\Models\EntityModel');
    }
}
