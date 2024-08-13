Заказ #{{ $order->id }}

Пользователь: {{ $order->user->username }}
Имя: {{ $order->user->full_name }}
Номер телефона: {{ $order->user->phone }}

Текст заказа:
{{ $order->text }}
