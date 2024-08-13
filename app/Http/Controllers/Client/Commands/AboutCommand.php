<?php

namespace App\Http\Controllers\Client\Commands;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class AboutCommand extends Command
{
    protected string $command = 'about';
    protected ?string $description = 'О нас';
    private string $templateName = 'info';

    public function handle(Nutgram $bot): void
    {
        $bot->sendMessage(view($this->templateName));
    }
}
