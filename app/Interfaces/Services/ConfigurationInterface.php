<?php

namespace App\Interfaces\Services;


use Illuminate\Support\Collection;

interface ConfigurationInterface {

    /**
     * @param String $orderByAttribute
     * @param String $order
     * @param bool $checkOnlineStatus
     */
    public function list(String $orderByAttribute = 'primary', String $order = 'DESC', bool $checkOnlineStatus = true) : Collection;

    /**
     * Store many records
     *
     * @param array $data
     */
    public function multiStoreOrUpdate(array $data)  : Collection;

    /**
     * Check if given host is online
     *
     * @param String $ip
     */
    public function isOnline(String $ip) : bool;
}
