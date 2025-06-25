<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\PterodactylService;

class PterodactylController extends Controller
{
    public function servers(PterodactylService $pterodactyl)
    {
        $servers = $pterodactyl->getServers();
        return response()->json($servers);
    }
} 