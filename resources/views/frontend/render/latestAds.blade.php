@foreach($latestAds as $latestAd)
    @include('frontend.render.advertisement', ['product' => $latestAd])
@endforeach
