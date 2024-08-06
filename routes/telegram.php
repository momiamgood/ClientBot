<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Http\Controllers\Client\Commands\InfoController;
use App\Http\Controllers\Client\Commands\OrderController;
use App\Http\Controllers\Client\Commands\StartController;
use App\Http\Controllers\Client\Handlers\OrderConversation;
use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Nutgram Handlers
|--------------------------------------------------------------------------
|
| Here is where you can register telegram handlers for Nutgram. These
| handlers are loaded by the NutgramServiceProvider. Enjoy!
|
*/

Route::post('/webhook', [TelegramController::class, 'handle']);

$bot->onCommand('start', StartController::class);
$bot->onCommand('info', InfoController::class);
$bot->onCommand('products', StartController::class);
$bot->onCommand('my-orders', StartController::class);
$bot->onCommand('order', OrderController::class);
$bot->onCallbackQuery('create_order', OrderConversation::class);

