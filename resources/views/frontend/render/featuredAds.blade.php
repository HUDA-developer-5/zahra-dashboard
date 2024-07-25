@foreach($featuredAds as $featuredAd)
    @include('frontend.render.advertisement', ['product' => $featuredAd])
@endforeach
