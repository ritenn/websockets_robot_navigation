<?php

namespace Tests\Feature;

use App\Models\Configuration;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    private $headers;

    public function __construct()
    {
        parent::__construct();

        $this->headers = [
            "Accept" => "application/json"
        ];
    }

    /**
     * @test
     */
    public function canList()
    {
        $data = factory(Configuration::class, 5)
            ->create()
            ->map->only(['uuid', 'name', 'hostname', 'port', 'rotation_speed', 'left_engine_speed', 'right_engine_speed', 'primary']);

        $data = collect($data)
            ->sortByDesc('primary')
            ->toArray();

        $response = $this->get('/api/configuration', $this->headers);
//        $response->dump();
        $response->assertStatus(200)
            ->assertJson(['message' => 'Configuration list.'])
            ->assertJson(['data' => array_values($data)]);
    }

    /**
     * @test
     */
    public function canCreate()
    {

        $data = factory(Configuration::class, 3)->make();

        $response = $this->post('/api/configuration', $data->toArray(), $this->headers);
//        $response->dump();
        $response->assertStatus(201)
            ->assertJson(['message' => 'Configuration stored sucessfully.']);
    }

    /**
     * @test
     */
    public function canDelete()
    {
        $configuration = factory(Configuration::class)->create();

        $response = $this->delete('/api/configuration/' . $configuration->uuid, $this->headers);
//        $response->dump();
        $response->assertStatus(200)
            ->assertJson(['message' => 'Configuration removed sucessfully.']);
    }
}
