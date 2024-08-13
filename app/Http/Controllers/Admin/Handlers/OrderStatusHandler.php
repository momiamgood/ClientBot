<?php

namespace App\Http\Controllers\Admin\Handlers;

use App\Models\Order;
use App\Traits\KeyboardTrait;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class OrderStatusHandler
{
    use KeyboardTrait;

    private Order $order;
    private array $keyboardArray;

    public function __invoke(Nutgram $bot, $status, $order_id): void
    {
        Log::debug('OrderStatusHandler->__invoke');
        $this->keyboardArray = config('telegram.keyboards.order_status');
        $this->order = Order::find($order_id);
        $this->order->update([
            'status' => $status
        ]);

        $this->updateOrderCard($bot);
    }

    private function updateOrderCard(Nutgram $bot): void
    {
        Log::debug('OrderStatusHandler->updateOrderCard');
        $bot->deleteMessage($bot->chatId(), $bot->callbackQuery()->message->message_id);
        $bot->sendMessage(
            text: view('order.admin.card', [
                'order' => $this->order
            ]),
            chat_id: $bot->chatId(),
            reply_markup: $this->setKeyboardByStatus()
        );
    }


    private function setKeyboardByStatus(): ?InlineKeyboardMarkup
    {
        Log::debug('OrderStatusHandler->setKeyboardByStatus');

        if ($this->order->status == Order::STATUS_COMPLETE) {
            return null;
        }

        $buttons = [];
        switch ($this->order->status) {
            case Order::STATUS_APPROVED:
                $buttons = InlineKeyboardButton::make(
                    text: 'В работу',
                    callback_data: 'order_set_status:' . Order::STATUS_IN_PROGRESS . ':' . $this->order->id
                );
                break;
            case Order::STATUS_IN_PROGRESS:
                $buttons = InlineKeyboardButton::make(
                    text: 'Выполнен',
                    callback_data: 'order_set_status:' . Order::STATUS_COMPLETE . ':' . $this->order->id
                );
                break;
        }

        return InlineKeyboardMarkup::make()->addRow($buttons);
    }
}
