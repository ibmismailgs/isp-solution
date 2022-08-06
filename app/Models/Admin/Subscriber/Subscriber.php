<?php

namespace App\Models\Admin\Subscriber;

use App\Models\Admin\Settings\Area;
use App\Models\Admin\Settings\Device;
use App\Models\Admin\Settings\Package;
use App\Models\Admin\Settings\Identity;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Settings\ConnectionType;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Subscriber\SubscriberCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscriber extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subscribers';

    public function idcards(): BelongsTo
    {
        return $this->belongsTo(Identity::class, 'card_type_id', 'id')->withTrashed();
    }
    public function areas(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id', 'id')->withTrashed();
    }
    public function categories(): BelongsTo
    {
        return $this->belongsTo(SubscriberCategory::class, 'category_id', 'id')->withTrashed();
    }
    public function connections(): BelongsTo
    {
        return $this->belongsTo(ConnectionType::class, 'connection_id', 'id')->withTrashed();
    }
    public function packages(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id', 'id')->withTrashed();
    }
    public function devices(): BelongsTo
    {
        return $this->belongsTo(Device::class, 'device_id', 'id')->withTrashed();
    }

}

