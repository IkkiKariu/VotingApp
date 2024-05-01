<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Participation extends Model
{
    use HasFactory;

    protected $table = 'participations';

    protected $fillable = [
        'user_id',
        'survey_id'
    ];

    public $timestamps = false;
    
    protected function casts()
    {
        return [
            'user_id' => 'integer',
            'survey_id' => 'integer'
        ];
    }



    public function survey(): HasOne
    {
        return $this->hasOne(Survey::class, 'id', 'survey_id');
    }
}
