<?php

namespace App\Models;

use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use CrudTrait;
    use HasFactory, SoftDeletes, HasTranslations, HasTranslatedName;

    protected $table = "cities";

    protected $fillable = ['name', 'status', 'nationality_id', 'state_id', 'name_ar'];

    protected array $translatable = ['name'];

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class, 'nationality_id', 'id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
}
