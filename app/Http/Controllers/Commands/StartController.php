<?php

namespace App\Http\Controllers\Commands;

use App\Http\Controllers\Controller;
use SergiX44\Nutgram\Nutgram;

class StartController extends Controller
{
    private string $templateName = 'start';

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage(view('start'));
    }
}
