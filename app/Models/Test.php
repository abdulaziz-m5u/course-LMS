<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->withTrashed();
    }
    
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id')->withTrashed();
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_test');
    }
    
}
