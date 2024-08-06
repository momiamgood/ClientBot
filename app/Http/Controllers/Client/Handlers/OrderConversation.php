<?php

namespace App\Http\Controllers\Client\Handlers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Template;
use App\Models\User;
use App\Traits\KeyboardTrait;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;
use function Laravel\Prompts\text;

class OrderConversation extends Conversation
{
    use KeyboardTrait;

    private Order $order;
    private User $user;
    protected ?string $step = 'firstStep';

    public function firstStep(Nutgram $bot): void
    {
        $this->user = User::where('chat_id', $bot->chatId());

        $template = 'order.steps.first_step';
        $bot->sendMessage(text: view($template));

        $this->next('secondStep');
    }

    public function secondStep(Nutgram $bot): void
    {
        $template = 'order.steps.second_step';
        $this->order = Order::create([
            'text' => $bot->message()->getText(),
            'user_id' => $this->user->id
        ]);

        $bot->sendMessage(text: view($template));
        $this->next('thirdStep');
    }


    public function thirdStep(Nutgram $bot): void
    {
        $template = 'order.steps.third_step';
        $this->user::update([
           'phone_number' => ''
        ]);

        $bot->sendMessage(text: view($template));

        $this->next('thirdStep');
    }


    public function orderCreated(Nutgram $bot): void
    {
        $template = 'order.created';
        $bot->sendMessage(text: view($template));

        $this->end();
    }
}
