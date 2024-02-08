<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLessonLog extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'user_lesson_logs';

    protected $fillable = ['user_id', 'course_id', 'lesson_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id' ,'id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id' ,'id');
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'lesson_id' ,'id');
    }
}
