<?php

namespace App\Observers;

use App\Models\Order;
use SergiX44\Nutgram\Nutgram;

class OrderObserver
{
    public function updated(Order $order): void
    {
        if ($order->status == Order::STATUS_COMPLETE) {
            $bot = new Nutgram(env('TELEGRAM_TOKEN'));

            $this->sendUserNotification($order, $bot);
        }
    }

    private function sendUserNotification(Order $order, Nutgram $bot): void
    {
        $bot->sendMessage(
            text: 'Ваш заказ выполнен! Можете забрать его в рабочее время с 8:00 до 22:00',
            chat_id: $order->user->chat_id
        );
    }
}
