<?php namespace Vazmer\Media;

use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$configPath = __DIR__ . '/../../config/media.php';
		$this->mergeConfigFrom($configPath, 'media');
	}

}
