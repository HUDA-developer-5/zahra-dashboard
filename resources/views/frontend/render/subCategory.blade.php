@foreach($subcategories as $subCategory)
    <div class="item">
        <div class="category text-center">
            <div class="img mb-2">
                <img src="{{ $subCategory->image_path }}" alt="{{ $subCategory->name }}" class="img-fluid" loading="lazy">
            </div>
            <h6 class="name">{{ $subCategory->name }}</h6>
        </div>
    </div>
@endforeach
