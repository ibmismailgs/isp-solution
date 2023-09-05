<?php

namespace App\Helper;

use App\Models\Admin\Account\Transaction;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable
{
    public static function postBalance($account_id)
    {
        $ini = \App\Models\Admin\Account\Account::findOrFail($account_id);

        $credit = Transaction::where('account_id', $account_id)
            ->where('transaction_type', 2)->sum('transaction_amount');

        $debit = Transaction::where('account_id', $account_id)
            ->where('transaction_type', 1)->sum('transaction_amount');

        $total = ((float)$credit + (float)$ini->initial_balance) - (float)$debit;

        return $total;
    }
}
