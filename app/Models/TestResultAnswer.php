<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResultAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['test_result_id', 'question_id', 'question_option_id', 'correct'];
}
