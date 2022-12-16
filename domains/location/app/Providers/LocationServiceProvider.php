<?php

namespace Domains\Location\Providers;

use Illuminate\Support\ServiceProvider;

class LocationServiceProvider extends ServiceProvider
{
	/**
	 * Register any package services.
	 */
	public function register()
	{
		/* */
	}

	/**
	 * Bootstrap any package services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

		$this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
	}
}
