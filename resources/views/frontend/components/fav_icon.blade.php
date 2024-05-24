
@if($isFav)
    <a href="{{ route('web.products.favourite.remove', ['id'=>$product_id]) }}" class="wishlist clicked">
        <i class="fas fa-heart"></i>
    </a>
@else
    <a href="{{ route('web.products.favourite.add', ['id'=>$product_id]) }}" class="wishlist">
        <i class="far fa-heart"></i>
    </a>
@endif