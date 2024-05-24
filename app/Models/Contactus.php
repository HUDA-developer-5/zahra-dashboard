<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'name', 'email', 'phone_number', 'message', 'status'];
}
