<?php

namespace App\Interfaces\Repository;


use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseInterface {

    /**
     * Model namespace
     */
    public function model();

    /**
     * Set model
     */
    public function setModel();

    /**
     * @param array $multiDimensionData
     * @param array $findByAttributes
     */
    public function updateOrCreateMulti(array $multiDimensionData, array $findByAttributes = []) : Collection;

    /**
     * @param array $checkForKeysValues
     * @param array $data
     */
    public function updateOrCreate(array $checkForKeysValues, array $data) : Model;

    /**
     * @param string $attribute
     * @param string $value
     * @param string $operator
     */
    public function findWhere(string $attribute, string $value, string $operator = "=") : Object;

    /**
     * @param String $orderByAttribute
     * @param string $order
     *
     * @return Collection
     */
    public function getAllOrderBy(String $orderByAttribute, String $order = "DESC") : Collection;
}
