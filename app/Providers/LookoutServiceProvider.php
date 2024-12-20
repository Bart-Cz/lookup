<?php

namespace App\Providers;

use App\Interfaces\LookupClientApiInterface;
use App\Services\LookupApi\LookupClientApi;
use App\Services\Lookup\MinecraftService;
use App\Services\LookupApi\MinecraftApi;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\LookupApiInterface;
use App\Services\Lookup\SteamService;
use App\Services\LookupApi\SteamApi;
use App\Services\Lookup\XblService;
use App\Services\LookupApi\XblApi;

class LookoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        // in case we want to change to other client
        $this->app->bind(LookupClientApiInterface::class, LookupClientApi::class);

        $this->app->when(MinecraftService::class)
            ->needs(LookupApiInterface::class)
            ->give(function () {
                return new MinecraftApi(app(LookupClientApiInterface::class));
            });

        $this->app->when(SteamService::class)
            ->needs(LookupApiInterface::class)
            ->give(function () {
                return new SteamApi(app(LookupClientApiInterface::class));
            });

        $this->app->when(XblService::class)
            ->needs(LookupApiInterface::class)
            ->give(function () {
                return new XblApi(app(LookupClientApiInterface::class));
            });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
