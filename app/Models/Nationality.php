<?php

namespace App\Models;

use App\Enums\CommonStatusEnums;
use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nationality extends Model
{
    use CrudTrait;
    use HasFactory, SoftDeletes, HasTranslations, HasTranslatedName;

    protected $table = "nationalities";

    protected array $translatable = ['name'];

    protected $fillable = ['name', 'code', 'status', 'order', 'name_ar'];

    public function states(): HasMany
    {
        return $this->hasMany(State::class, 'nationality_id', 'id');
    }
}
