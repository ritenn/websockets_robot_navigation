<?php

namespace App\Services;


use App\Interfaces\Services\BaseInterface;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Mixed_;

class BaseService implements BaseInterface {

    /**
     * Begin transaction
     */
    public function beginTransaction() : void
    {
        DB::beginTransaction();
    }

    /**
     * Rollback DB
     *
     * @param String $message
     *
     * @return bool
     */
    public function rollback(String $message) : bool
    {
        DB::rollBack();
        \Log::error(__METHOD__ . " " . $message);

        return false;
    }

    /**
     * Commit DB
     *
     * @param $data
     *
     * @return mixed
     */
    public function commit($data)
    {
        DB::commit();

        return $data;
    }
}
