<?php

namespace App\Repository;


use App\Interfaces\Repository\ConfigurationInterface;

class ConfigurationRepository extends BaseRepository implements ConfigurationInterface {

    public function model() {
        return 'App\Models\Configuration';
    }


}
