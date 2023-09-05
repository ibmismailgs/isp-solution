<?php

namespace App\Models\Admin\Billing;

use App\Models\Admin\Account\Account;
use App\Models\Admin\Settings\Package;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Subscriber\Subscriber;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Billing extends Model
{
    use HasFactory, SoftDeletes;

    protected $table ='billings';
    protected $fillable = [
        'name',
        'subscriber_id',
        'contact_no',
        'billing_month',
        'process_date',
        'code',
        'package_id'
    ];

    public function subscribers(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class, 'subscriber_id', 'id')->withTrashed();
    }
    public function packages(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'id')->withTrashed();
    }
    public function accounts(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id', 'id')->withTrashed();
    }
}
