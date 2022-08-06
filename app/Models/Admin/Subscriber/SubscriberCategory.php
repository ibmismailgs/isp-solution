<?php

namespace App\Models\Admin\Subscriber;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriberCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'subscriber_categories';
}
