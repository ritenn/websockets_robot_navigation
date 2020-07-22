<?php

namespace App\Traits;


trait UuidTrait {

    protected static function bootUuidAction() {

        static::creating(function ($model) {
            $model->uuid = (string) \Str::uuid();
        });
    }
}
