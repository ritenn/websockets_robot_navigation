<?php

namespace App\Models;


use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use UuidTrait;

    protected $guarded = ['uuid'];
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';

    public $incrementing = false;

    public function getFillable()
    {
        return $this->fillable;
    }

    protected static function boot()
    {
        parent::boot();
        parent::bootUuidAction();
    }

}
