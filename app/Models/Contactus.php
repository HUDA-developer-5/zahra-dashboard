<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = ['title', 'name', 'email', 'phone_number', 'message', 'status'];
}
