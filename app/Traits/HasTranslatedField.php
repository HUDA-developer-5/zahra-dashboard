<?php

namespace App\Traits;

trait HasTranslatedField
{
    public function addTranslatedField($crud, string $label, string $field, string $type, array $languagesKeysWithNames)
    {
        foreach ($languagesKeysWithNames as $key => $name) {
            $crud->addField([
                'name' => $field.'_'.$key,
                'label' => $label,
                'type' => $type,
                'tab' => $name,
            ]);
        }
        return $crud;
    }

    public function addSearchableColumn($crud, string $field, string $label)
    {
        return $crud->addColumn([
            'name' => "$field",
            'limit' => 500,
            'label' => $label,
            'searchLogic' => function ($query, $column, $searchTerm) use ($field) {
                $query->orWhere(function ($q) use ($searchTerm, $field) {
                    $q->whereRaw("LOWER(json_extract({$field},'$.en')) like ?", ["%" . strtolower($searchTerm) . "%"])
                        ->orWhereRaw("LOWER(json_extract({$field},'$.ar')) like ?", ["%" . strtolower($searchTerm) . "%"]);
                });
            }
        ]);
    }
}