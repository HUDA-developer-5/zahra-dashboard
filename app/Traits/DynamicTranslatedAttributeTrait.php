<?php

namespace App\Traits;

trait DynamicTranslatedAttributeTrait
{
    public function generateAttributeFunctions(array $fields, array $languagesKeys): void
    {
        foreach ($fields as $field) {
            $this->setAttributeFunction($field, $languagesKeys);
//            $this->getAttributeFunction($field, $languagesKeys);
        }
    }

    protected function setAttributeFunction($field, $languagesKeys)
    {
//        $this->{"set" . ucfirst($field) . "Attribute"} = function ($value) use ($field, $languagesKeys) {
        $values = [];
        foreach ($languagesKeys as $languageKey) {
            $values[$languageKey] = request()->{$field . "_" . $languageKey};
        }
        $this->attributes[$field] = json_encode($values);
//        };
    }

    protected function getAttributeFunction($field, $languagesKeys): void
    {
        foreach ($languagesKeys as $languageKey) {
            $fieldName = strtolower($field) . "_" . strtolower($languageKey);
            $this->{"get" . ucfirst($fieldName) . "Attribute"} = function () use ($field, $languageKey) {
                return key_exists("$languageKey", $this->getTranslations("$field")) ? $this->getTranslations("$field")["$languageKey"] : "";
            };
        }
    }
}