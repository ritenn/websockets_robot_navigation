<?php

namespace App\Interfaces\Services;


interface BaseInterface {

    /**
     * Begin transaction
     */
    public function beginTransaction() : void;

    /**
     * Rollback DB
     *
     * @param String $message
     */
    public function rollback(String $message) : bool;

    /**
     * Commit DB
     *
     * @param $data
     */
    public function commit($data);
}
