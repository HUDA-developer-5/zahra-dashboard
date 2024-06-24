<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'newsletters';

    protected $fillable = ['email'];
}
