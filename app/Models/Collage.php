<?php

namespace App\Models;

use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collage extends Model
{
    use HasFactory, HasTranslatedName, SoftDeletes, CrudTrait, HasTranslations;

    protected $table = 'collages';

    protected $fillable = ['name', 'name_ar', 'status', 'university_id'];

    protected array $translatable = ['name'];

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class, 'university_id', 'id');
    }
}