<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'question_test');
    }

}
