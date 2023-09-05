<?php

namespace App\Models\FrontEnd;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MessageStore extends Model
{
    use HasFactory, SoftDeletes;
}
