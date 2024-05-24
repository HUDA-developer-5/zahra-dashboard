<?php

namespace App\Services;

use App\Enums\CommonStatusEnums;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function listParent()
    {
        return Category::where('status', "=", CommonStatusEnums::Active->value)
            ->whereNull('parent_id')
            ->paginate(25);
    }

    public function listChild(int $categoryId, array $with = [])
    {
        $query = Category::where('status', "=", CommonStatusEnums::Active->value)
            ->where('parent_id', '=', $categoryId);
        if (!empty($with)) {
            $query->with($with);
        }
        return $query->get();
    }

    public function listCatsToMenu()
    {
        return Category::where('status', "=", CommonStatusEnums::Active->value)->whereNull('parent_id')->with('child')->get();
    }

    public function listParentCatsToHome(string $search = null)
    {
        return Category::where('status', "=", CommonStatusEnums::Active->value)->whereNull('parent_id')
            ->when($search, function (Builder $query, $value) {
                return $query->where(DB::raw('LOWER(name->"$.en")'), 'like', "%" . strtolower($value) . "%")
                    ->orWhere(DB::raw('LOWER(name->"$.ar")'), 'like', "%" . strtolower($value) . "%");
            })->get();
    }

    public function listChildCatsToHome()
    {
        return Category::where('status', "=", CommonStatusEnums::Active->value)->whereNotNull('parent_id')->get();
    }

    public function find(int $id)
    {
        return Category::where('status', "=", CommonStatusEnums::Active->value)->find($id);
    }

    public function getCategoriesByIds(array $ids)
    {
        return Category::whereIn('id', $ids)->get();
    }
}