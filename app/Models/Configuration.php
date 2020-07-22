<?php

namespace App\Models;


use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use UuidTrait;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        parent::bootUuidAction();
    }

}
