<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use CrudTrait;
    use HasFactory, HasTranslations, HasTranslatedName, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = ['name', 'name_ar', 'status', 'parent_id'];

    protected array $translatable = ['name'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function child(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
