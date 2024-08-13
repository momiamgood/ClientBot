<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use SergiX44\Nutgram\Nutgram;


class AdminChatMiddleware
{
    public function __invoke(Nutgram $bot, $next): void
    {
        if ($bot->chatId() == config(['chats']['admin'])){
            $next($bot);
        }

        $bot->sendMessage('Forbidden');
    }
}
