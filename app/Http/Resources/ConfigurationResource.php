<?php

namespace App\Http\Resources;


use App\Interfaces\Services\ConfigurationInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class ConfigurationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "uuid" => $this->uuid,
            "name" => $this->name,
            "hostname" => $this->hostname,
            "port" => (int) $this->port,
            "rotation_speed" => (int) $this->rotation_speed,
            "left_engine_speed" => (int) $this->left_engine_speed,
            "right_engine_speed" => (int) $this->right_engine_speed,
            "primary" => (boolean) $this->primary,
            "online" => $this->online ?? false
        ];
    }
}
