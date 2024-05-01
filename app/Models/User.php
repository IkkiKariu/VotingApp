<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are gimass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'login',
        'password',
        'name',
        'bio'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }


    protected function casts()
    {
        return [
            'login' => 'string',
            'password' => 'string',
            'name' => 'string',
            'bio' => 'string'
        ];
    }

    public function surveys(): HasMany
    {
        return $this->hasMany(Survey::class, 'creator_id');
    }

    public function participated(): HasMany
    {
        return $this->hasMany(Participation::class, 'user_id');
    }
}
