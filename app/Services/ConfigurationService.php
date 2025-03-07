<?php

namespace App\Services;


use App\Interfaces\Services\ConfigurationInterface;
use App\Interfaces\Repository\ConfigurationInterface as ConfigInterface;
use Symfony\Component\Process\Process;
use Illuminate\Support\Collection;

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
     * @param bool $checkOnlineStatus
     *
     * @return \Illuminate\Support\Collection
     */
    public function list(String $orderByAttribute = 'primary', String $order = 'DESC', bool $checkOnlineStatus = true) : Collection
    {
        $resources = $this->configurationRepository->getAllOrderBy($orderByAttribute, $order);

        if ($checkOnlineStatus)
        {
            foreach ($resources as $resource)
            {
                $resource->online = $this->isOnline($resource->hostname);
            }
        }

        return $resources;
    }

    /**
     * Store many records
     *
     * @param array $data
     *
     * @return \Illuminate\Support\Collection
     */
    public function multiStoreOrUpdate(array $data) : Collection
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

    /**
     * Check if given host is online
     *
     * @param String $ip
     *
     * @return bool
     */
    public function isOnline(String $ip) : bool
    {
        $process = new Process(['ping', '-c 1', '-W 1', $ip]);
        $process->run();
        $output = $process->getOutput();
        $packetsPos = strpos( $output, "1 packets transmitted, ") + 22;
        $endOfStatus = strpos( $output, "received", $packetsPos);

        if ($packetsPos !== 0 && $endOfStatus !== 0)
        {
            return (bool) trim(substr($output, $packetsPos, $endOfStatus - $packetsPos));
        }

        return false;
    }
}
