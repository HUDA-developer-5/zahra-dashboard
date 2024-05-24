<?php

namespace App\Models;

use App\Helpers\FilesHelper;
use App\Traits\HasImage;
use App\Traits\HasTranslatedDescription;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use CrudTrait;
    use HasFactory, HasTranslatedName, HasTranslatedDescription, HasTranslations, SoftDeletes, HasImage;

    protected $table = "banners";

    public static string $destination_path = 'banners';

    protected array $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'image',
        'status',
        'link',
        'start_date',
        'end_date',
        'description',
        'name_ar',
        'description_ar',
    ];

    public function setImageAttribute($value)
    {
        $this->setImageAttributeValue($value, 'image');
    }

    public function getImagePathAttribute(): string
    {
        return FilesHelper::filePath($this->image);
    }
}
