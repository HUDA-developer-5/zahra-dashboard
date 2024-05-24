$(function () {
    /*console*/
    ("use strict");
    $(document).ready(function(){
        var documentDir = $('body').attr('dir') == 'rtl' ? 'left' : 'right';
        var header = $("header");
        //sticky-header
        $(window).scrollTop() >= header.height() && $(window).width() >= 768
            ? header.addClass("sticky-header").fadeIn()
            : header.removeClass("sticky-header");
    
        $(window).scroll(function () {
            //if condition
            $(window).scrollTop() >= header.height() && $(window).width() >= 768
            ? header.addClass("sticky-header").fadeIn()
            : header.removeClass("sticky-header");
        });

        $('.select2').each(function(){
            $(this).select2({
                placeholder: $(this).find('option:first').attr('label'),
                minimumResultsForSearch: Infinity,
                width: '100%'
            });
        });
        /* $('.site-lang').change(function(){
            var langVal = $(this).val();
            if(langVal == 2) {
                $('link[href="https://fastly.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"]').remove();
                $('body').addClass('rtl').attr('dir','rtl');
                $('head').prepend(`<link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">`);
            } else {
                $('link[href="https://fastly.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"]').remove();
                $('body').removeClass('rtl').attr('dir','rtl');
                $('head').prepend(`<link href="https://fastly.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">`);
            }
        }); */

        $('.password-show').click(function(){
            let passwordInput = $(this).closest('.form-input').find('input');
            if(passwordInput.attr('type') == 'password'){
                $(this).html('').append(`<i class="far fa-eye-slash"></i>`);
                passwordInput.attr('type', 'text');
            }
            else {
                $(this).html('').append(`<i class="far fa-eye"></i>`);
                passwordInput.attr('type', 'password');
            }
        })

        $('.sec-check').click(function(){
            if(!$(this).hasClass('disabled')) {
                $(this).toggleClass('checked');
                var typeCheck = $(this).find('input[type="checkbox"]')
                if(typeCheck.is(':checked')) {
                    typeCheck.prop('checked', false);
                } else {
                    typeCheck.prop('checked', true);
                }
    
                if($(this).hasClass('negotiable')){
                    var nonNegotiable = $(this).parent().find('.non-negotiable');
                    nonNegotiable.toggleClass('disabled');
                }
                if($(this).hasClass('non-negotiable')){
                    var Negotiable = $(this).parent().find('.negotiable');
                    Negotiable.toggleClass('disabled');
                }
            }

        });

        $('.filters .form-check.sub-types').each(function(){
            $(this).click(function(){
                $(this).toggleClass('collapsed').find('>ul').slideToggle();
            })
        })

        $('.filters .form-check.sub-types input, .filters .form-check.sub-types ul').click(function(event){event.stopPropagation()});

        $('.btn-recharge').click(function(){
            $('.wallet-recharge').toggleClass('d-none');
        })
        //Slick Slider
        let rtlVal = $('body').attr('dir') == 'rtl' ? true : false;
        if ($('.slider-single').length != 0 ) {
            $('.slider-single').slick({
                rtl: rtlVal,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                fade: false,
                adaptiveHeight: true,
                infinite: false,
                useTransform: true,
                speed: 400,
                cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
            });
    
            $('.slider-nav')
                .on('init', function (event, slick) {
                    $('.slider-nav .slick-slide.slick-current').addClass('is-active');
                })
                .slick({
                    //rtl: rtlVal,
                    slidesToShow: 6,
                    slidesToScroll: 6,
                    dots: false,
                    focusOnSelect: true,
                    infinite: false,
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                vertical: false,
                                verticalSwiping: false,
                            }
                        }
                    ]
                });
    
            $('.slider-single').on('afterChange', function (event, slick, currentSlide) {
                $('.slider-nav').slick('slickGoTo', currentSlide);
                var currrentNavSlideElem = '.slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
                $('.slider-nav .slick-slide.is-active').removeClass('is-active');
                $(currrentNavSlideElem).addClass('is-active');
            });
    
            $('.slider-nav').on('click', '.slick-slide', function (event) {
                event.preventDefault();
                var goToSingleSlide = $(this).data('slick-index');
    
                $('.slider-single').slick('slickGoTo', goToSingleSlide);
            });
        }

        //price range
        const rangeInput = document.querySelectorAll(".range-input input"),
            priceInput = document.querySelectorAll(".price-input input"),
            range = document.querySelector(".slider .progress");
        let priceGap = 1000;

        priceInput.forEach((input) => {
        input.addEventListener("input", (e) => {
            let minPrice = parseInt(priceInput[0].value),
            maxPrice = parseInt(priceInput[1].value);

            if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
            if (e.target.className === "input-min") {
                rangeInput[0].value = minPrice;
                range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
            } else {
                rangeInput[1].value = maxPrice;
                range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
            }
            }
        });
        });

        rangeInput.forEach((input) => {
        input.addEventListener("input", (e) => {
            let minVal = parseInt(rangeInput[0].value),
            maxVal = parseInt(rangeInput[1].value);

            if (maxVal - minVal < priceGap) {
            if (e.target.className === "range-min") {
                rangeInput[0].value = maxVal - priceGap;
            } else {
                rangeInput[1].value = minVal + priceGap;
            }
            } else {
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
            range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
            range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
            }
        });
        });


        $('.uploader-card .uploader-preview-main .file-delete').click(function(){
            $(this).closest('.uploader-card').remove();
        });

        if($('#pro_images #upload_image').length > 0) {
            let fileInput = document.getElementById("upload_image");
            fileInput.onchange = function () {
                preview_images(fileInput , 'img');
            }
        }
        if($('#pro_videos #upload_video').length > 0) {
            let fileInput = document.getElementById("upload_video");
            fileInput.onchange = function () {
                preview_images(fileInput, 'video');
            }
        }
        function preview_images(fileInput, type) {
            var total_file = fileInput.files.length;
            for(var i=0;i<total_file;i++){
                if(type == 'img') {
                    $('#pro_images #uploader-list').append(`
                                              <div class="uploader-card">
                                                  <div class="uploader-preview-main">
                                                      <div class="file-delete"><i class="fas fa-times"></i></div>
                                                      <img alt="preview" class="files_img" src="${URL.createObjectURL(event.target.files[i])}">
                                                  </div>
                                                  <div class="d-flex main-img-check">
                                                      <input class="form-check-input" type="radio" name="main_img" id="main_img">
                                                      <label class="form-check-label" for="main_img"> <span class="ms-1">Main img</span></label>
                                                  </div>
                                              </div>`);
                }
                if( type == 'video' ) {
                    $('#pro_videos #uploader-list').append(`
                                            <div class="uploader-card">
                                                <div class="uploader-preview-main">
                                                    <div class="file-delete"><i class="fas fa-times"></i></div>
                                                    <video poster="assets/images/video-poster.png"></video>
                                                </div>
                                                <div class="d-flex main-img-check">
                                                    <input class="form-check-input" type="radio" name="main_img" id="main_img">
                                                    <label class="form-check-label" for="main_img"> <span class="ms-1">Main img</span></label>
                                                </div>
                                            </div>`);
                }
            }
            deleteBtnTrigger();
        } 

        function deleteBtnTrigger(){
            $('.uploader-card .uploader-preview-main .file-delete').unbind('click');
            $('.uploader-card .uploader-preview-main .file-delete').click(function(){
                $(this).closest('.uploader-card').remove();
            });
        }
        
        $('.form-wizard .wizard-fieldset .price-type').change(function(){
            if ($(this).val() == 2){
                $('.form-wizard .wizard-fieldset .main-type').addClass('d-none');
                $('.form-wizard .wizard-fieldset .offer-type').removeClass('d-none');

            } else{
                $('.form-wizard .wizard-fieldset .offer-type').addClass('d-none');
                $('.form-wizard .wizard-fieldset .main-type').removeClass('d-none');
            }

        })
        
        $('.form-wizard .wizard-fieldset .check-form input[type="radio"]').change(function(){
            let checkInputVal = $(this).val();
            if( checkInputVal == "premium")
                $('.form-wizard .wizard-fieldset .premium-info').removeClass('d-none');
            else
                $('.form-wizard .wizard-fieldset .premium-info').addClass('d-none');
        });

        //Wishlist        
        $('.ads-list-sec .wishlist, #product-banner .model-list .wishlist').click(function(){
            $(this).toggleClass('clicked');
        })

        $(".categories-carousel, .sub-category-carousel").owlCarousel({
            rtl: rtlVal,
            dots: false,
            nav: false,
            autoplay: true,
            autoplayHoverPause: true,
            loop: false,
            margin: 10,
            responsive: {
                0: {
                    items: 3,
                },
                768: {
                    items: 5,
                },
                992: {
                    items: 6,
                },
                1200: {
                    items: 8,
                },
                1400: {
                    items: 12,
                },
            },
        });

        //follow comment
        $('#product-comments .comment .options .list .follow-comment').click(function(){
            $(this).addClass('d-none');
            $(this).parent().find('.following').removeClass('d-none');
        })
        $('#product-comments .comment .options .list .following').click(function(){
            $(this).addClass('d-none');
            $(this).parent().find('.follow-comment').removeClass('d-none');
        })
        

        // profile image upload
        if($('#img-upload-input').length > 0) {
            let fileInput = document.getElementById("img-upload-input");
            let fileSelect = document.getElementsByClassName("img-upload-select")[0];
            fileSelect.onclick = function () {
                fileInput.click();
            }
            fileInput.onchange = function () {
                $('.profile-image').attr('src', '');
            }
        }
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});