<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = "questions";

    protected $fillable = [
        "question_title",
        "answer"
    ];

    public function forms()
    {
        return $this->belongsToMany(Form::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
