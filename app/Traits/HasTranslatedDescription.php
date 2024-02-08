<?php

namespace App\Traits;

trait HasTranslatedDescription
{
    use HasTranslatedField;

    public function setDescriptionArAttribute($value)
    {
        return $this->attributes['description'] = json_encode(["en" => request()->description_en, "ar" => request()->description_ar]);
    }

    public function getDescriptionArAttribute()
    {
        return key_exists('ar', $this->getTranslations('description')) ? $this->getTranslations('description')['ar'] : '';
    }

    public function getDescriptionEnAttribute()
    {
        return key_exists('en', $this->getTranslations('description')) ? $this->getTranslations('description')['en'] : '';
    }
}
