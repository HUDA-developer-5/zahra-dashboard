<?php

namespace App\Models;

use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use CrudTrait;
    use HasFactory, HasTranslations, HasTranslatedName, SoftDeletes;

    protected $table = 'countries';

    protected $fillable = ['name', 'name_ar', 'status'];

    protected array $translatable = ['name'];
}
