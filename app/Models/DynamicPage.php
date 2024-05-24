<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicPage extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'dynamic_pages';

    protected $fillable = [
        'slug',
        'title_ar',
        'title_en',
        'content_ar',
        'content_en',
    ];
}
