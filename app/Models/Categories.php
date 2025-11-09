<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model {
    protected $guarded = [];

    // Define relationships
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
