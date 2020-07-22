<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Configuration;
use Faker\Generator as Faker;

$factory->define(Configuration::class, function (Faker $faker) {

    return [
        'uuid' => "",
        'name' => $faker->name,
        'hostname' => $faker->ipv4,
        'port' => 80,
        'rotation_speed' => numberBetweenFromCfgArray($faker, 'rotation_speed_range'),
        'left_engine_speed' => numberBetweenFromCfgArray($faker, 'left_engine_speed_range'),
        'right_engine_speed' => numberBetweenFromCfgArray($faker, 'right_engine_speed_range'),
        'primary' => $faker->boolean
    ];
});

if (!function_exists("numberBetweenFromCfgArray")) {
    /**
     * Helper function - convert config values to params
     *
     * @param Faker $faker
     * @param String $configValue - configuration file value
     *
     * @return int
     */
    function numberBetweenFromCfgArray(Faker $faker, string $configValue)
    {
        $values = config('configuration.' . $configValue);

        return (int) call_user_func_array(array($faker, 'numberBetween'), $values);
    }
}
