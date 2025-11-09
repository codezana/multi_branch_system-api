<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLogs extends Model
{
    protected $table = 'activity_logs';
    protected $guarded = [];

    // Define relationships
    public function user() {
        return $this->belongsTo(User::class);
    }
}
