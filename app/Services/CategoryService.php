<?php

namespace App\Services;

use App\Enums\CommonStatusEnums;
use App\Models\Category;

class CategoryService
{
    public function listParent()
    {
        return Category::where('status', "=", CommonStatusEnums::Active->value)
            ->whereNull('parent_id')
            ->paginate(25);
    }

    public function listChild(int $categoryId)
    {
        return Category::where('status', "=", CommonStatusEnums::Active->value)
            ->where('parent_id', '=', $categoryId)
            ->get();
    }
}