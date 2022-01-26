<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student')->withTimestamps()->withPivot(['rating']);;
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('position');
    }

    public function getRatingAttribute()
    {
        return number_format(DB::table('course_student')->where('course_id', $this->attributes['id'])->average('rating'), 2);
    }


}

