<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'course_image',
        'start_date',
        'published'
    ];

    public function teachers(){
        return $this->belongsToMany(User::class, 'course_user');
    }

    public function getPublishedAttribute($attribute){
        return [
            0 => 'Inactive',
            1 => 'Active'
        ][$attribute];
    }

    public function scopeOfTeacher($query)
    {
        if (!auth()->user()->isAdmin()) {
            return $query->whereHas('teachers', function($q) {
                $q->where('user_id', auth()->user()->id);
            });
        }
        return $query;
    }

    public function publishedLessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position')->where('published', 1);
    }
}
