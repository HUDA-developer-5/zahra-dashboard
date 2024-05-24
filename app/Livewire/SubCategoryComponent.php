<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class SubCategoryComponent extends Component
{
    public $subCategories;
    public $parentId;

    protected $listeners = ['showSubcategories'];

    public function render()
    {
        if ($this->parentId) {
            $this->subCategories = Category::where('parent_id', $this->parentId)->get();
        } else {
            $this->subCategories = collect(); // Empty collection if no parent selected
        }

        return view('livewire.sub-category-component');
    }
}
