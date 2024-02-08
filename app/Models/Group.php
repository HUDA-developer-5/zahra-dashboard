<?php

namespace App\Models;

use App\Traits\HasTranslatedDescription;
use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use CrudTrait, HasFactory, HasTranslations, HasTranslatedName, HasTranslatedDescription, SoftDeletes;

    protected $table = 'groups';

    protected $fillable = ['teacher_id', 'course_id', 'status', 'name', 'name_ar', 'number_of_students', 'price_for_individual', 'total_price', 'start_date', 'end_date'];

    protected array $translatable = ['name'];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_users', 'group_id');
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'group_lessons', 'group_id');
    }
}
