<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseUniversity extends Model
{
    use HasFactory;

    protected $table = 'course_universities';

    protected $fillable = ['course_id', 'university_id'];

    protected array $translatable = ['name'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class, 'university_id', 'id');
    }
}
