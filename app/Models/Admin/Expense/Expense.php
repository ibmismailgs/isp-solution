<?php

namespace App\Models\Admin\Expense;

use App\Models\Admin\Account\Account;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Expense\ExpenseCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    public function excategory(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id', 'id')->withTrashed();
    }

    public function accounts(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id')->withTrashed();
    }
}
