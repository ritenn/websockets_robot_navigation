<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;
use App\Interfaces\Services\ConfigurationInterface;
use App\Interfaces\Repository\ConfigurationInterface as ConfigInterface;

class ConfigurationService extends BaseService implements ConfigurationInterface {

    private $configurationRepository;

    /**
     * ConfigurationService constructor.
     *
     * @param App\Interfaces\Repository\ConfigurationInterface $configurationRepository
     */
    public function __construct(ConfigInterface $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    /**
     * @param String $orderByAttribute
     * @param String $order
     *
     * @return \Illuminate\Support\Collection
     */
    public function list(String $orderByAttribute = "primary", String $order = "DESC")
    {
        return $this->configurationRepository->getAllOrderBy($orderByAttribute, $order);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function multiStoreOrUpdate(array $data)
    {
        $this->beginTransaction();

        try {

            $resource = $this->configurationRepository->updateOrCreateMulti($data, ['uuid']);

        } catch (\Exception $e)
        {

            return $this->rollback($e->getMessage());
        }

        return $this->commit($resource);
    }
}
