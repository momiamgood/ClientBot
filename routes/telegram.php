<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Http\Controllers\Admin\Handlers\OrderStatusHandler;
use App\Http\Controllers\Client\Commands\AboutCommand;
use App\Http\Controllers\Client\Commands\OrderCommand;
use App\Http\Controllers\Client\Commands\StartCommand;
use App\Http\Controllers\Client\Conversations\OrderConversation;
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

$bot->onCallbackQueryData('create_order:1', OrderConversation::class);

$bot->registerCommand(StartCommand::class);
$bot->registerCommand(AboutCommand::class);
$bot->registerCommand(OrderCommand::class);

$bot->onCallbackQueryData('order_set_status:{status}:{order_id}', OrderStatusHandler::class);






