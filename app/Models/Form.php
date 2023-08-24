<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $table = "forms";

    protected $fillable = [
        "slug",
        "user_id",
        "share_url",
        "name",
        "description",
        "question_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }
}
