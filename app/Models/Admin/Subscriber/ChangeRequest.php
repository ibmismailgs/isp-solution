<?php

namespace App\Models\Admin\Subscriber;

use App\Models\Admin\Settings\Area;
use App\Models\Admin\Settings\Package;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Settings\ConnectionType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChangeRequest extends Model
{
    use HasFactory, SoftDeletes;

    public function areas(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id', 'id')->withTrashed();
    }
    public function connections(): BelongsTo
    {
        return $this->belongsTo(ConnectionType::class, 'connection_id', 'id')->withTrashed();
    }
    public function packages(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'id')->withTrashed();
    }
    public function subscribers(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class, 'subscriber_id', 'id')->withTrashed();
    }
}
