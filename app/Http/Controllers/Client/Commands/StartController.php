<?php

namespace App\Http\Controllers\Client\Commands;

use App\Http\Controllers\Controller;
use App\Models\User;
use SergiX44\Nutgram\Nutgram;

class StartController extends Controller
{
    private User $user;
    private string $templateName = 'start';

    public function __invoke(Nutgram $bot): void
    {
        $this->user = User::create([
            'chat_id' => $bot->chatId(),
            'username' => $bot->user()->username,
        ]);

        $bot->sendMessage(view($this->templateName));
    }
}
