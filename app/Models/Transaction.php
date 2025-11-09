<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    protected $table = 'transactions';
    protected $guarded = [];

    // Define relationships
    public function branch() {
        return $this->belongsTo(Branch::class);
    }

    public function category() {
        return $this->belongsTo(Categories::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
