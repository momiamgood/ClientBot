<?php

namespace App\Http\Controllers\Client\Conversations;

use App\Events\OrderCompleted;
use App\Listeners\SendOrderToAdminChat;
use App\Models\Order;
use App\Models\User;
use App\Traits\KeyboardTrait;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class OrderConversation extends Conversation
{
    public ?Order $order;
    public ?User $user = null;
    use KeyboardTrait;

    protected ?string $step = 'askDescription';

    public function __construct(Nutgram $bot)
    {
        $orderId = $bot->getUserData('order_id');
        $this->order = Order::find($orderId);
        $this->user = User::findByChayId($bot->chatId());
    }

    /**
     * @param Nutgram $bot
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * Запрашиваем описание заказа
     *
     */
    public function askDescription(Nutgram $bot): void
    {
        Log::debug('askDescription');
        $bot->deleteMessage($bot->chatId(), $bot->messageId());
        $this->user = User::findByChayId($bot->chatId());

        $bot->sendMessage(
            text: 'Заполните описание заказа, наиболее подробно опишите свои ожидания, чтобы наши мастера могли в точности воспроизвести Вашу задумку:'
        );

        $this->next('handleOrderDescription');
    }


    /**
     * @param Nutgram $bot
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * Обрабатываем запрошенное описание
     *
     */
    public function handleOrderDescription(Nutgram $bot): void
    {
        Log::debug('handleOrderDescription');

        $this->order = Order::create([
            'text' => $bot->message()->getText(),
            'user_id' => $this->user->id,
            'status' => Order::STATUS_NEW
        ]);

        $this->askNumber($bot);
    }


    /**
     * @param Nutgram $bot
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * Запрос актуального номера телефона
     *
     */
    public function askNumber(Nutgram $bot): void
    {
        if ($this->user->phone) {
            $this->orderCreated($bot);
            return;
        }

        Log::debug('askNumber');

        $bot->sendMessage('Наипшите актульаный телефон для связи:', $bot->chatId());

        $this->next('handleNumber');
    }

    /**
     * @param Nutgram $bot
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * Обработка запрошенного номера телефона
     *
     */
    public function handleNumber(Nutgram $bot): void
    {
        Log::debug('handleNumber');

        $this->user->update([
            'phone' => $bot->message()->getText()
        ]);

        $this->orderCreated($bot);
    }

    /**
     * @param Nutgram $bot
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * Завершение заполнения заявки, отправка карточки заказа в административный чат
     *
     */
    public function orderCreated(Nutgram $bot): void
    {
        Log::debug('orderCreated');

        $bot->sendMessage(
            text: 'Вы успешно заполнили заявку! Сейчас наши администраторы занимаются ее обработкой, в течение для Вам поступит звонок для уточннения информации по заказу и его подтверждения!'
        );

        Log::debug($this->order);

        $bot->sendMessage(
            text: view('order.admin.card', [
                'order' => $this->order
            ]),
            chat_id: config('chats.admin'),
            reply_markup: InlineKeyboardMarkup::make()
                ->addRow(
                    InlineKeyboardButton::make('Подтвержден', callback_data: 'order_set_status:'. Order::STATUS_APPROVED . ':'. $this->order->id),
                    InlineKeyboardButton::make( 'Отменен', callback_data: 'order_set_status:'. Order::STATUS_REJECT . ':'. $this->order->id),
                )
        );

        $this->end();
    }
}
