<?php

namespace App\Models;

use App\Helpers\FilesHelper;
use App\Traits\HasImage;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, CrudTrait, SoftDeletes, HasImage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'email_verified_at',
        'password',
        'phone_number',
        'phone_number_verified_at',
        'whatsapp_number',
        'image',
        'nationality_id',
    ];

    public static string $destination_path = 'users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setImageAttribute($value)
    {
        $this->setImageAttributeValue($value, 'image');
    }

    public function getImagePathAttribute(): string
    {
        return FilesHelper::filePath($this->image);
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class, 'nationality_id', 'id');
    }
}