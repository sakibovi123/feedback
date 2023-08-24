<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = "feedback";
    protected $fillable = [
        "name",
        "email",
        "form_id",
        "answer"
    ];

    public function forms()
    {
        return $this->belongsTo(Form::class);
    }


}
