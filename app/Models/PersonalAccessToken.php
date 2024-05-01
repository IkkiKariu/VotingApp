<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PersonalAccessToken extends Model
{
    use HasFactory;

    protected $table = 'personal_access_tokens';

    public function user() : HasOne
    {
        return $this->hasOne(User::class, 'id', 'tokenable_id');
    }
}
