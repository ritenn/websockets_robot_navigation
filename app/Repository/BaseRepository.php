<?php

namespace App\Repository;


use App\Interfaces\Repository\BaseInterface;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository implements  BaseInterface {

    /**
     * @var Container - Application container
     */
    private $app;

    /**
     * @var $model - repository definied namespace
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param Container $app
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
        $this->setModel();
    }

    /**
     * Model namespace
     *
     * @return string
     */
    abstract public function model();

    /**
     * Set model
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setModel()
    {
        $this->model = $this->app->make($this->model());
    }

    /**
     * @param array $multiDimensionData
     * @param array $findByAttributes
     *
     * @return Collection
     */
    public function updateOrCreateMulti(array $multiDimensionData, array $findByAttributes = []) : Collection
    {
        $resource = array();

        foreach ($multiDimensionData as $data)
        {

            $findBy = array_flip($findByAttributes);
            $checkForKeysValues = array_intersect_key($data, $findBy);
            $data = array_diff_key($data, $findBy);

            $resource[] = $this->updateOrCreate($checkForKeysValues, $data);

        }

        return collect($resource);
    }

    /**
     * @param array $checkForKeysValues
     * @param array $data
     *
     * @return Model
     */
    public function updateOrCreate(array $checkForKeysValues, array $data) : Model
    {
        return $this->model->updateOrCreate($checkForKeysValues, $data);
    }

    /**
     * @param string $attribute
     * @param string $value
     * @param string $operator
     *
     * @return mixed
     */
    public function findWhere(string $attribute, string $value, string $operator = "=") : Object
    {
        return $this->model->where($attribute, $operator, $value);
    }

    /**
     * @param String $orderByAttribute
     * @param string $order
     *
     * @return Collection
     */
    public function getAllOrderBy(String $orderByAttribute, String $order = "DESC") : Collection
    {
        return $this->model->orderBy($orderByAttribute, $order)->get();
    }
}
