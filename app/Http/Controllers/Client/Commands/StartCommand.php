<?php

namespace App\Http\Controllers\Client\Commands;

use App\Models\User;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class StartCommand extends Command
{
    private ?User $user;
    private string $templateName = 'start';
    protected string $command = 'start';
    protected ?string $description = 'Начало';

    public function handle(Nutgram $bot): void
    {
        $this->user = User::firstOrCreate(
            ['chat_id' => $bot->chatId()],
            [
                'username' => $bot->user()->username or null,
                'full_name' => ''
            ]);

        $bot->sendMessage(view($this->templateName));
    }
}

