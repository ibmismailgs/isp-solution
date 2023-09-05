<?php

namespace App\Models\Admin\Account;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Subscriber\Subscriber;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillPay extends Model
{
    use HasFactory,SoftDeletes;

    public function subscribers(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class, 'client_id', 'id')->withTrashed();
    }
}
