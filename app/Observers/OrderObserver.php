<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Status;
use App\Traits\KeyboardTrait;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use function Laravel\Prompts\text;

class OrderObserver
{
    use KeyboardTrait;
    public function created(Order $order, Nutgram $bot): void
    {
        $bot->sendMessage(
            text: view('order.card', [
                'order' => $order
            ]),
            chat_id: config(['chats']['admin']),
            reply_markup: InlineKeyboardMarkup::make()
                ->addRow(
                    InlineKeyboardButton::make('В работу', callback_data: 'set_status:'. Order::STATUS_IN_PROGRESS),
                )
        );
    }
}
