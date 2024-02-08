<?php

namespace App\Models;

use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use CrudTrait, HasFactory, HasTranslatedName, HasTranslations, SoftDeletes;

    protected $table = 'sections';

    protected $fillable = ['name', 'name_ar', 'course_id', 'order'];

    protected array $translatable = ['name'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class,'course_id', 'id');
    }
}
