<?php

namespace App\Services;

class SteamWorkshop
{
    public string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.steam_workshop.api_key');
    }

    public function getWorkshopItemFromSteam_id(int $steamId): array
    {
        $response = \Http::get("https://api.steampowered.com/ISteamRemoteStorage/GetPublishedFileDetails/v1/", [
            'key' => $this->apiKey,
            'steamid' => $steamId,
        ]);

        if($response->successful()) {
            dd($response->json());
        } else {
            dd($response->status());
        }
    }
}
