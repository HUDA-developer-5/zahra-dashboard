<?php

namespace App\Models;

use App\Helpers\FilesHelper;
use App\Traits\HasImage;
use App\Traits\HasTranslatedDescription;
use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, HasTranslatedName, SoftDeletes, CrudTrait, HasTranslations, HasTranslatedDescription, HasImage;

    protected $table = 'courses';

    protected $fillable = ['name', 'name_ar', 'status', 'teacher_id', 'code', 'type', 'duration', 'image', 'intro_video', 'description', 'description_ar'];

    protected array $translatable = ['name', 'description'];

    public static string $destination_path = 'courses';

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'course_categories', 'course_id');
    }

    public function universities(): BelongsToMany
    {
        return $this->belongsToMany(University::class, 'course_universities', 'course_id');
    }

    public function setImageAttribute($value)
    {
        $this->setImageAttributeValue($value, 'image');
    }

    public function getImagePathAttribute(): string
    {
        return FilesHelper::filePath($this->image);
    }

    public function subscribedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_courses', 'course_id', 'user_id');
    }
}
