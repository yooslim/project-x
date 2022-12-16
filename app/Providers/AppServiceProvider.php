<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Factory::guessFactoryNamesUsing(function (string $modelName) {
            // Get the domain name
            $domain = Str::betweenFirst($modelName, '\\', '\\');

            // Get the model name
            $model = Str::afterLast($modelName, '\\');

            // We can also customise where our factories live too if we want:
            $namespace = 'Domains\\' . $domain . '\\Database\\Factories\\';

            // Finally we'll build up the full class path where
            // Laravel will find our model factory
            return $namespace.$model.'Factory';
        });

        Factory::guessModelNamesUsing(function (Factory $factory) {
            // Get the domain name
            $domain = Str::betweenFirst(get_class($factory), '\\', '\\');

            // Get the model name
            $model = Str::beforeLast(Str::afterLast(get_class($factory), '\\'), 'Factory');

            return 'Domains\\' . $domain . '\\Models\\' . $model;
        });
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
