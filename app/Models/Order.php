<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    const STATUS_NEW = 1;
    const STATUS_APPROVED = 2;

    const STATUS_IN_PROGRESS = 3;
    const STATUS_COMPLETE = 4;
    const STATUS_REJECT = 0;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
