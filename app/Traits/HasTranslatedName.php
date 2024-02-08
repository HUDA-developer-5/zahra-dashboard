<?php

namespace App\Traits;

trait HasTranslatedName
{
    use HasTranslatedField;

    public function setNameArAttribute($value)
    {
        return $this->attributes['name'] = json_encode(["en" => request()->name_en, "ar" => request()->name_ar]);
    }

    public function getNameArAttribute()
    {
        return key_exists('ar', $this->getTranslations('name')) ? $this->getTranslations('name')['ar'] : '';
    }

    public function getNameEnAttribute()
    {
        return key_exists('en', $this->getTranslations('name')) ? $this->getTranslations('name')['en'] : '';
    }
}
