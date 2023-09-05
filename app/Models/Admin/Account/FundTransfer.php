<?php

namespace App\Models\Admin\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FundTransfer extends Model
{
    use HasFactory,SoftDeletes;

    public function accounts(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'from_account_id', 'id')->withTrashed();
    }
    public function FundTransfers(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'to_account_id', 'id')->withTrashed();
    }
}

