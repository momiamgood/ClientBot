<?php

namespace App\Http\Controllers\Client\Handlers;

use App\Models\Order;
use App\Models\User;
use App\Traits\KeyboardTrait;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class OrderConversation extends Conversation
{
    use KeyboardTrait;

    private Order $order;
    private User $user;
    protected ?string $step = 'firstStep';

    /**
     * @param Nutgram $bot
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * Запрашиваем описание заказа
     *
     */
    public function firstStep(Nutgram $bot): void
    {
        $this->user = User::where('chat_id', $bot->chatId());

        $template = 'order.steps.first_step';
        $bot->sendMessage(text: view($template));

        $this->next('secondStep');
    }

    /**
     * @param Nutgram $bot
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * Запрашиваем номер телефона
     *
     */

    public function secondStep(Nutgram $bot): void
    {
        $template = 'order.steps.second_step';
        $this->order = Order::create([
            'text' => $bot->message()->getText(),
            'user_id' => $this->user->id,
            'status' => Order::STATUS_NEW
        ]);

        $bot->sendMessage(text: view($template));
        $this->next('thirdStep');
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
        $template = 'order.created';
        $bot->sendMessage(text: view($template));

        $this->end();
    }
}
