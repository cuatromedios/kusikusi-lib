<?php

namespace Kusikusi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Mimey\MimeTypes;
use Kusikusi\Models\EntityModel;

class WebsiteModel extends EntityModel
{

    protected $contentFields = [ "title"];

    protected static function boot()
    {
        parent::boot();
    }
}
