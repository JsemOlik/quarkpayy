<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PterodactylService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.pterodactyl.url');
        $this->apiKey = config('services.pterodactyl.key');
    }

    protected function apiRequest($method, $endpoint)
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->$method($this->baseUrl . $endpoint);
    }

    public function getServers()
    {
        $response = $this->apiRequest('get', '/servers?include=node');
        $servers = $response->json('data') ?? [];
        // Map to only needed fields
        return array_map(function ($server) {
            return [
                'id' => $server['attributes']['id'],
                'name' => $server['attributes']['name'],
                'suspended' => $server['attributes']['suspended'],
                'node' => $server['attributes']['node'] ?? null,
                'node_id' => $server['attributes']['node_id'] ?? null,
            ];
        }, $servers);
    }

    public function getServerResource($serverId)
    {
        // This endpoint is for the client API, not application API, so you may need to use the client API for resource usage
        // For now, just return null
        return null;
    }
} 