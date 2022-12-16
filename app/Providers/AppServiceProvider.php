<?php

namespace App\Providers;

use App\Utils\DomainDrivenFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias(Factory::class, DomainDrivenFactory::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Disable "data" wrapping when returning resources in customer api
        JsonResource::withoutWrapping();
    }
}
