<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $table = 'question_options';

    protected $fillable = [
        'title',
        'question_id',
        'is_correct'
    ];
    protected function casts()
    {
        return [
            "is_correct" => "boolean",
        ];
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
