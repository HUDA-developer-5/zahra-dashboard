<?php

namespace App\Livewire;

use App\Services\CategoryService;
use Livewire\Component;

class Category extends Component
{
    public $selectedParentCategory = null;
    public $subCategories = [];
    public $homeParentCategories = [];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $categoryService = new CategoryService();
        $this->homeParentCategories = $categoryService->listParentCatsToHome();
        $this->selectedParentCategory = $this->homeParentCategories->first()?->id;
        $this->subCategories = $categoryService->listChild($this->selectedParentCategory);
    }

    public function toggleSubCategories($categoryId)
    {
        $this->selectedParentCategory = $categoryId;
        $categoryService = new CategoryService();
        $this->subCategories = $categoryService->listChild($categoryId);
        $this->dispatch('categoriesUpdated', $this->selectedParentCategory); // Emit event with payload
    }

    public function render()
    {
        return view('livewire.category');
    }
}
