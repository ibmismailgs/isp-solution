<?php

namespace App\Models\Admin\Account;

use App\Models\Admin\Account\Bank;
use App\Models\Admin\Account\Account;
use App\Models\Admin\Expense\Expense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    public function accounts(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id')->withTrashed();
    }

    public function expenses(): BelongsTo
    {
        return $this->belongsTo(Expense::class, 'expense_id', 'id')->withTrashed();
    }

}
