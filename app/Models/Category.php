<?php

namespace App\Models;

use App\Helpers\FilesHelper;
use App\Traits\HasImage;
use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use CrudTrait;
    use HasFactory, HasTranslations, HasTranslatedName, SoftDeletes, HasImage;

    protected $table = 'categories';

    public static string $destination_path = 'categories';

    protected $fillable = ['name', 'name_ar', 'status', 'image', 'parent_id'];

    protected array $translatable = ['name'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    public function child(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function setImageAttribute($value)
    {
        $this->setImageAttributeValue($value, 'image');
    }

    public function getImagePathAttribute(): string
    {
        return FilesHelper::filePath($this->image);
    }
}
