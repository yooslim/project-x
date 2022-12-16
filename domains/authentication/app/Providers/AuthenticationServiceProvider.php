<?php

namespace Domains\Authentication\Providers;

use Domains\Authentication\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class AuthenticationServiceProvider extends ServiceProvider
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

        Factory::useNamespace('\\');
	}
}
