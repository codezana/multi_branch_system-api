<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'balances';
    protected $guarded = [];

    // Define relationships
    public function branch() {
        return $this->belongsTo(Branch::class);
    }
}
