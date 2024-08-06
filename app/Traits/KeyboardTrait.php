<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use SergiX44\Nutgram\Telegram\Types\Keyboard\KeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardMarkup;

trait KeyboardTrait
{
    public function createKeyboardFormCollection(Collection $collection): ReplyKeyboardMarkup
    {
        $keyboardButtonArray = [];
        foreach ($collection as $item) {
            $keyboardButtonArray[] = KeyboardButton::make($item->name);
        }

        return ReplyKeyboardMarkup::make()->addRow($keyboardButtonArray);
    }
}
