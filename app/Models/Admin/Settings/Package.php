<?php

namespace App\Models\Admin\Settings;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Settings\ConnectionType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'packages';

    public function connections(): BelongsTo
    {
        return $this->belongsTo(ConnectionType::class, 'connection_type_id', 'id')->withTrashed();
    }
}
