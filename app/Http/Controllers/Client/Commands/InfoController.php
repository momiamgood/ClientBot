<?php

namespace App\Http\Controllers\Client\Commands;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SergiX44\Nutgram\Nutgram;

class InfoController extends Controller
{
    private string $templateName = 'info';

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage(view($this->templateName));
    }
}
