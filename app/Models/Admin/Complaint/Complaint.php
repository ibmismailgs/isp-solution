<?php

namespace App\Models\Admin\Complaint;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Complaint\Classification;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complaint extends Model
{
    use HasFactory, SoftDeletes;
    public function classifications(): BelongsTo
    {
        return $this->belongsTo(Classification::class, 'classification_id', 'id')->withTrashed();
    }
}
