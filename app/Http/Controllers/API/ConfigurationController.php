<?php

namespace App\Http\Controllers\API;


use App\Http\Requests\ConfigurationRequest;
use App\Http\Resources\ConfigurationResource;
use App\Interfaces\Services\ConfigurationInterface;
use App\Models\Configuration;

class ConfigurationController extends Controller
{
    /**
     * @var ConfigurationInterface - configurations service
     */
    private $configurationService;

    /**
     * ConfigurationController constructor.
     *
     * @param ConfigurationInterface $configurationService
     */
    public function __construct(ConfigurationInterface $configurationService)
    {
        $this->configurationService = $configurationService;
    }

    /**
     * List configurations
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $resource = $this->configurationService->list();

        return $this->jsonResponse('Configuration list.', ConfigurationResource::collection($resource), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConfigurationRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ConfigurationRequest $request)
    {
        if ($resource = $this->configurationService->multiStoreOrUpdate($request->input()))
        {

            return $this->jsonResponse('Configuration stored sucessfully.', $resource, 201);

        } else {

            return $this->jsonResponse('Failed to store/udpate configuration.', [], 200, true);
        }

    }

    /**
     * Remove configuration
     *
     * @param Configuration $configuration
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Configuration $configuration)
    {
        if ($configuration->delete())
        {
            return $this->jsonResponse('Configuration removed sucessfully.', [], 200);

        } else {

            return $this->jsonResponse('Failed to remove configuration.', [], 200, true);
        }
    }
}
