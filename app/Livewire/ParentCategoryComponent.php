<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class ParentCategoryComponent extends Component
{
    public $componentParentCategories;
    public $componentSubCategories;

    public function mount()
    {
        $this->componentParentCategories = Category::whereNull('parent_id')->get();
        $this->componentSubCategories = collect();
    }

    public function render()
    {
        return view('livewire.parent-category-component');
    }

    public function showSubcategories($parentId)
    {
        $this->componentSubCategories = Category::where('parent_id', $this->parentId)->get();
//        $this->emit('showSubcategories', $parentId);
    }
}
