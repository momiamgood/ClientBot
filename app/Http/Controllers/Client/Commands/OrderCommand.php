<?php

namespace App\Http\Controllers\Client\Commands;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class OrderCommand extends Command
{
    protected string $command = 'order';
    protected ?string $description = 'Сделать заказ';
    public string $templateName = 'order';

    public function handle(Nutgram $bot): void
    {
        $bot->sendMessage(text: view($this->templateName), reply_markup: InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make('Сделать заказ', callback_data: 'create_order:1'),
            ));
    }
}
