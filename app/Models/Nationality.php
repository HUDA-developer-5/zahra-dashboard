<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'nationalities';

    protected $fillable = ["name", "status", "code", 'order'];

    protected $translatable = ["name"];

//    protected $casts = [
//        'name' => 'array'
//    ];
}
