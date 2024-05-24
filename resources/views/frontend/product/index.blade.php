@extends('frontend.layouts.master')

@section("style")
@endsection

@section('content')
    <div id="main-wrapper">
        <div id="page-title" class="py-5">
            <div class="container">
                <div class="content-txt">
                    <h2 class="title">{{ trans('web.Categories') }}</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="{{ route('web.home') }}">{{ trans('web.Home') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('web.Category') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div id="categories" class="mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 mb-3 mb-lg-0">
                        <div class="category-filter filters bg-white">
                            <div class="accordion" id="filterAccordion">
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#CategoryCollapse" aria-expanded="true"
                                                aria-controls="CategoryCollapse">
                                            {{ trans('web.Categories') }}
                                        </button>
                                    </h2>
                                </div>
                                <div id="CategoryCollapse" class="accordion-collapse collapse show"
                                     aria-labelledby="headingOne">
                                    <div class="search-input mb-2">
                                        {{ html()->form('get')->open() }}
                                            <input type="text" name="search" id="filter-search" class="form-control" value="{{ $search }}"
                                                   placeholder="{{ trans('web.Search') }}">
                                            <span class="icon"><i class="fas fa-magnifying-glass"></i></span>
                                        {{ html()->form()->close() }}
                                    </div>
                                    <div class="list">
                                        @if($parentCategories->count())
                                            @foreach($parentCategories as $parentCategory)
                                                <div>
                                                    <a href="{{ url()->route('web.categories').'?category_id='.$parentCategory->id  }}"
                                                       class="{{ ($selectedCat->id == $parentCategory->id) ? "active" : "" }}">{{ $parentCategory->name }}</a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($subCategories->count())
                        <div class="col-lg-9">
                            <div class="categories-level mb-3">
                                <h5 class="level-title fw-bold mb-2">{{ $selectedCat->name }}</h5>
                                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6">

                                    @foreach($subCategories as $subCategory)
                                        <div class="col">
                                            <div class="category {{ ($loop->first) ? "active" : "" }} text-center">
                                                <div class="img mb-2">
                                                    <img src="{{ $subCategory->image_path }}"
                                                         alt="{{ $subCategory->name }}" class="img-fluid"
                                                         loading="lazy">
                                                </div>
                                                <h6 class="name">{{ $subCategory->name }}</h6>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@stop

@section("script")

@endsection
