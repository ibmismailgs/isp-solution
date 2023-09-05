<?php

namespace App\Models\Admin\Settings;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    public function roles(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role', 'id');
    }
}
