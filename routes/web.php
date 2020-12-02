<?php


use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::post('/telegram/{apiSecret}', [TelegramController::class, 'index']);


Route::get('/telegram', [TelegramController::class, 'hello']);

if (env('APP_ENV') === 'local')
{
    Route::get('/test', function () {
        phpinfo();
    });

    Route::get('/redis', function () {

        /** @var Redis $redis */
        $redis = resolve('Redis');
        $testKey = 'abcd';

        $redis->set($testKey, '1234');

        $testResult = $redis->get($testKey);

        $redis->del($testKey);
        return $testResult;

    });

}


