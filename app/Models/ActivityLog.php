<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'user_name', 'category', 'action', 'description', 'details', 'created_at'];
    protected $casts = ['details' => 'array', 'created_at' => 'datetime'];
}
