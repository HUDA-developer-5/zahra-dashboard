<?php

namespace App\Models;

use App\Enums\CommonStatusEnums;
use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use CrudTrait;
    use HasFactory, SoftDeletes, HasTranslations, HasTranslatedName;

    protected $table = "states";

    protected $fillable = ['name', 'status', 'nationality_id', 'name_ar'];

    protected array $translatable = ['name'];

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class, 'nationality_id', 'id');
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'state_id', 'id');
    }
}
