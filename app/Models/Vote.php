<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vote extends Model
{
    use HasFactory;

    protected $table = 'votes';

    protected $fillable = [
        'decision_id',
        'user_id'
    ];

    protected function casts()
    {
        return [
            'decision_id' => 'integer',
            'user_id' => 'integer'
        ];
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id');
    }  
}
