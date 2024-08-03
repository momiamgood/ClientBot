<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Http\Controllers\Commands\StartController;
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

