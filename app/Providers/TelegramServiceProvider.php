<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Longman\TelegramBot\Telegram;

class TelegramServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(Telegram::class, function ($app) {

            $telegram = new Telegram(env("TELEGRAM_BOT_API_KEY"), env("TELEGRAM_BOT_USERNAME"));


            //in testing, we don't need set DB for telegram
            $mysql_credentials = [
                'host' => env("DB_HOST"),
                'port' => env("DB_PORT"), // optional
                'user' => env("DB_USERNAME"),
                'password' => env("DB_PASSWORD"),
                'database' => env("DB_DATABASE"),
            ];

            $telegram->enableMySql($mysql_credentials, env("TELEGRAM_DB_PREFIX", ""));


            $commands_paths =
                [//    __DIR__ . '/Command/',
                    app_path() . '/Classes/TelegramCommands/SystemCommands/',
                    app_path() . '/Classes/TelegramCommands/UserCommands/',
                    app_path() . '/Classes/TelegramCommands/',
                ];

            // Add commands paths containing your custom commands
            $telegram->addCommandsPaths($commands_paths);

            return $telegram;
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
}
