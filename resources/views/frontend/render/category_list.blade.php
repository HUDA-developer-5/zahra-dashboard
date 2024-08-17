@if(!empty($categories) && $categories->count())
    @foreach($categories as $menuCategory)
        <li class="form-check @if($menuCategory->child?->count()) sub-types @endif">
            <input name="categories_id[]" class="form-check-input" type="checkbox"
                   value="{{ $menuCategory->id }}" id="flexCheckChecked{{ $menuCategory->id }}" {{ in_array($menuCategory->id, request('categories_id', [])) ? 'checked' : '' }}>
            <label class="form-check-label"
                   for="flexCheckChecked{{ $menuCategory->id }}">{{ $menuCategory->name }}</label>

            @if($menuCategory->child?->count())
                <ul>
                    @include('frontend.render.category_list', ['categories' => $menuCategory->child])
                </ul>
            @endif
        </li>
    @endforeach
@else
    <li>{{ __('No categories found') }}</li>
@endif
