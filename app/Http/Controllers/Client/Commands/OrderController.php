<?php

namespace App\Http\Controllers\Client\Commands;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use function Laravel\Prompts\text;

class OrderController extends Controller
{
    public string $templateName = 'order';

    public function __invoke(Nutgram $bot): void
    {
        $bot->sendMessage(text: view($this->templateName), reply_markup: InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make('Сделать заказ', callback_data: 'create_order'),
            ));
    }
}
