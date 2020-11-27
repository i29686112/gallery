<?php


namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Redis;

class RedisServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(Redis::class, function ($app) {

            $redis = new Redis();
            $redis->connect(env('REDIS_HOST'), env('REDIS_PORT'));
            return $redis;

        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public
    function boot()
    {
        //
    }
}
