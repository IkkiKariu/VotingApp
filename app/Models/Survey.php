<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Survey extends Model
{
    use HasFactory;

    protected $table = 'surveys';

    protected $fillable = [
        'creator_id',
        'title',
        'content',
        'is_published',
        'published_at',
        'public_uid',
        'has_multiple_choice'
    ];

    protected function casts()
    {
        return [
            'creator_id' => 'integer',
            'title' => 'string',
            'content' => 'string',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'public_uid' => 'string',
            'has_multiple_choice' => 'boolean'
        ];
    }

    public function decisions(): HasMany
    {
        return $this->hasMany(Decision::class, 'survey_id');
    }

    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
