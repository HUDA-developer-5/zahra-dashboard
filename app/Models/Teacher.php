<?php

namespace App\Models;

use App\Helpers\FilesHelper;
use App\Traits\HasImage;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    use HasFactory, HasTranslations, CrudTrait, HasImage;

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'phone_number',
        'phone_number_verified_at',
        'type',
        'status',
        'whatsapp_number',
        'image',
        'nationality_id',
        'educations',
        'educations_ar',
    ];

    protected array $translatable = ['educations'];
    public static string $destination_path = 'teachers';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_number_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class, 'nationality_id', 'id');
    }

    public function setImageAttribute($value)
    {
        $this->setImageAttributeValue($value, 'image');
    }

    public function getImagePathAttribute(): string
    {
        return FilesHelper::filePath($this->image);
    }

    public function setEducationsArAttribute($value): bool|string
    {
        return $this->attributes['educations'] = json_encode(["en" => request()->educations_en, "ar" => request()->educations_ar]);
    }

    public function getEducationsArAttribute()
    {
        return key_exists('ar', $this->getTranslations('educations')) ? $this->getTranslations('educations')['ar'] : '';
    }

    public function getEducationsEnAttribute()
    {
        return key_exists('en', $this->getTranslations('educations')) ? $this->getTranslations('educations')['en'] : '';
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'teacher_categories', 'teacher_id');
    }
}
