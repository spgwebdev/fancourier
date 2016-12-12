<?php
namespace SeniorProgramming\FanCourier\Providers;

use Illuminate\Support\ServiceProvider;
/**
 * Class TwitchApiServiceProvider
 * @package Skmetaly\TwitchApi\Providers
 */
class ApiServiceProvider extends ServiceProvider  {
    
    /**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	//protected $defer = false;
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
    }
    /**
     *  Boot
     */
    public function boot()
    {
       $this->addConfig();
    }
    /**
     *  Registering services
     */
    private function registerServices()
    {
        $this->app->bind('fancourier','SeniorProgramming\FanCourier\Services\ApiService');
//        $this->app->singleton('FanCourier', function(){
//            
//            return new ApiService(config('username'), config('password'), config('client_id'));
//        });
        //$this->app->alias('FanCourier', 'fancourier');
        //dd(config('username'));
        //$this->app->bind('SeniorProgramming\Fancourier\Services\ApiService','SeniorProgramming\Fancourier\Services\ApiService');
    }
    
    /**
     *  Config publishing
     */
    private function addConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/fancourier.php', 'fancourier'
        );
//        //Publish config file
//        if(function_exists('config_path')){
//            //If is not a Lumen App...
//            $this->publishes([
//            __DIR__.'/../../config/fancourier.php' => config_path('fancourier.php'),
//        ]);
//        }
    }
    
    /**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}
}