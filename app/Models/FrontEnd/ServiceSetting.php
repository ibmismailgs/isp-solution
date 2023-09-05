<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceSetting extends Model
{
    use HasFactory, SoftDeletes;
}
