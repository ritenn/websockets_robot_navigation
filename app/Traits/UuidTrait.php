<?php

namespace App\Traits;


trait UuidTrait {

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';

    public $incrementing = false;

    protected static function bootUuidAction() {

        static::creating(function ($model) {
            $model->uuid = (string) \Str::uuid();
        });
    }
}
