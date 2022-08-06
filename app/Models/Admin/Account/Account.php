<?php

namespace App\Models\Admin\Account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    public function banks(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id')->withTrashed();
    }

    public function types(): BelongsTo
    {
        return $this->belongsTo(AccountType::class, 'account_type_id', 'id')->withTrashed();
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id', 'id')->withTrashed();
    }
}
