<div id="page-title" class="py-5">
    <div class="container">
        <div class="content-txt">
            <h2 class="title">{{ $title }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('web.home') }}">{{ trans('web.Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>