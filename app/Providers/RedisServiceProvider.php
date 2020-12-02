<?php


namespace App\Providers;


use Illuminate\Support\Facades\Log;
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

            $redisHost = env('REDIS_HOST');
            $redisPort = env('REDIS_PORT');
            $redisPassword = env('REDIS_PASSWORD');

            if (env('REDIS_URL') && $this->checkIsValidRedisURI(env('REDIS_URL')))
            {
                [$redisHost, $redisPort, $redisPassword] = $this->parseRedisURI(env('REDIS_URL'));
            }

            try
            {
                if ($redisHost && $redisPort)
                {
                    if ($redisPassword)
                    {
                        $redis->auth($redisPassword);
                    }
                    $redis->connect($redisHost, $redisPort);
                }
            } catch (\Exception $exception)
            {
                log::error(exceptionToString($exception));
            }


            return $redis;

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

    private function parseRedisURI($redisUrl)
    {
        return [
            parse_url($redisUrl, PHP_URL_HOST),
            parse_url($redisUrl, PHP_URL_PORT),
            parse_url($redisUrl, PHP_URL_PASS),
        ];

    }

    private function checkIsValidRedisURI($redisUrl)
    {

        return parse_url($redisUrl, PHP_URL_SCHEME) === 'redis';
    }
}
