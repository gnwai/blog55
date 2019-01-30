<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RiakServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }


    /*public function reg()
    {
        $this->app->singleton(aaa::class, function($app){
            return new aaa($app->make( bbb::class));
        });
    }*/

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        #wbz
        /*$this->app->singleton(Connection::class, function ($app) {
            return new Connection(config('riak'));
        });*/

        #wbz  绑定接口到实现
        /*$this->app->bind(
            'App\Contracts\EventPusher',
            'App\Services\RedisEventPusher'
        );*/
    }
}
