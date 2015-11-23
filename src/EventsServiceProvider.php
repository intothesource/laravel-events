<?php

namespace IntoTheSource\Events;

/**
 * 
 * @author Gertjan Roke <gjroke@intothesource.com>
 */

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class EventsServiceProvider extends ServiceProvider
{

    /**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	public function boot()
	{
        $this->loadViewsFrom(__DIR__ . '/views', 'Events');

        $this->setupRoutes($this->app->router);

        /* placing all the extending files */
        $this->publishes([
            __DIR__.'/config' => config_path(),
            __DIR__.'/database/migrations' => database_path('migrations'),
            __DIR__.'/Http/Controllers/publish' => app_path('Http/Controllers'),
            __DIR__.'/Models/publish' => app_path(),
        ]);
    }

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function setupRoutes(Router $router)
	{
		$router->group(['prefix' => config('source.events.prefix')], function($router)
		{
			require __DIR__.'/Http/routes.php';
		});
	}

	public function register()
	{
		$this->registerEvents();
		config([
				'config/source.events.php',
		]);
	}

	private function registerEvents()
	{
		$this->app->bind('events',function($app){
			return new Events($app);
		});
	}

}