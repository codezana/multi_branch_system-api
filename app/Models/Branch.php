<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Branch extends Model {

    use HasFactory;
    protected $table = 'branches';
    protected $guarded = [];

    // Define relationships
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
    public function balance() {
        return $this->hasOne(Balance::class);
    }
}
