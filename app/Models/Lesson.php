<?php

namespace App\Models;

use App\Traits\HasTranslatedDescription;
use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use CrudTrait;
    use HasFactory, HasTranslations, HasTranslatedName, HasTranslatedDescription, SoftDeletes;

    protected $table = 'lessons';

    protected $fillable = ['course_id', 'section_id', 'status', 'name', 'name_ar', 'order', 'type', 'link', 'free', 'description', 'description_ar'];

    protected array $translatable = ['name', 'description'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
    }
}
