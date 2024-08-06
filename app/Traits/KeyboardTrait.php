<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

trait KeyboardTrait
{
    public function createReplyKeyboardFormCollection(Collection $collection): ReplyKeyboardMarkup
    {
        $keyboardButtonArray = [];
        foreach ($collection as $item) {
            $keyboardButtonArray[] = KeyboardButton::make($item->name);
        }

        return ReplyKeyboardMarkup::make()->addRow($keyboardButtonArray);
    }


    public function createInlineKeyboardFormCollection($collection, $callbackName): InlineKeyboardMarkup
    {
        $keyboardButtonArray = [];
        foreach ($collection as $item) {
            $keyboardButtonArray[] = InlineKeyboardButton::make($item->name, callback_data: "$callbackName:$item->id");
        }

        return InlineKeyboardMarkup::make()->addRow($keyboardButtonArray);
    }

}
