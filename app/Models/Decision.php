<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Decision extends Model
{
    use HasFactory;

    protected $table = 'decisions';

    public $timestamps = false;

    protected $fillable = [
        'survey_id',
        'content',
        'vote_count'
    ];

    protected function casts()
    {
        return [
            'survey_id' => 'integer',
            'content' => 'string',
            'vote_count' => 'integer'
        ];
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'decision_id');
    }
}
