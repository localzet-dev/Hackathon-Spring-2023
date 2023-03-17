<?php

namespace resources;

use support\MongoModel;

class Model extends MongoModel
{
    protected $primaryKey = 'id';
    protected $keyType = 'int';

    protected $guarded = [];
    public static function new($attributes = [])
    {
        $id = self::all()->count() + 1;
        return self::create(['id' => $id] + $attributes);
    }
}
