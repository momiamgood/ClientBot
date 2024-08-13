<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SergiX44\Nutgram\Nutgram;

// TODO: Change name to WebhookController
class TelegramController extends Controller
{
    public function handle(Request $request, Nutgram $bot): void
    {
        $bot->registerMyCommands();
        $bot->run();
    }
}
