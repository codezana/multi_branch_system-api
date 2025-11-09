<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements JWTSubject {
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
    * The attributes that are mass assignable.
    *
    * @var list<string>
    */
    protected $guarded = [];

    /**
    * The attributes that should be hidden for serialization.
    *
    * @var list<string>
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

      public function getJWTIdentifier()
    {
        return $this->getKey(); // usually the user ID
    }

    public function getJWTCustomClaims()
    {
        return []; // you can return custom token data if needed
    }

    // Define relationships

    public function transactions() {
        return $this->hasMany( Transaction::class );
    }

    public function activityLogs() {
        return $this->hasMany( ActivityLogs::class );
    }

    public function branches() {
        return $this->hasMany( Branch::class, 'id', 'branch_id' );
    }

}
