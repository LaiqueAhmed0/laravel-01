<!-- begin::Global Config(global config for global JS sciprts) -->
<script>var HOST_URL = "https://mobile.eagle.brd.ltd";</script>
<script>
    var KTAppSettings = {
        "breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#6993FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1E9FF",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };</script>
<!--end::Global Config-->
@livewireScripts
<!-- end::Global Config -->
<script src="/plugins/global/plugins.bundle.js" type="text/javascript"></script>
<script src="/plugins/custom/prismjs/prismjs.bundle.js" type="text/javascript"></script>
<script src="/js/scripts.bundle.js" type="text/javascript"></script>
<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->
{{--<script src="/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>--}}
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
{{--		<script src="/js/pages/dashboard.js" type="text/javascript"></script>--}}

<script>
    document.addEventListener('livewire:init', function () {
        slider = document.getElementById('kt_price_slider');

        if (slider) {
            noUiSlider.create(slider, {
                start: [0, 70],
                connect: true,
                tooltips: [
                    wNumb({prefix: "&pound;", decimals: 2}),
                    wNumb({prefix: "&pound;", decimals: 2})
                ],
                range: {
                    'min': 0,
                    'max': 70
                }
            });

            let priceInputs = [
                $('#price_from'),
                $('#price_to'),
            ]

            slider.noUiSlider.on('update', function (values, handle) {
                priceInputs[handle].val(values[handle]);
                priceInputs[handle].trigger('change');
            });

        }
    });
</script>


<script>

    writeCookie = function (cname, cvalue, days) {
        var dt, expires;
        dt = new Date();
        dt.setTime(dt.getTime() + (days * 60 * 1000));
        expires = "; expires=" + dt.toGMTString();
        document.cookie = cname + "=" + cvalue + expires + '; domain=lovemobiledata.com';
    }

    var cookieValue = document.cookie.replace(/(?:(?:^|.*;\s*)LoggedIn\s*\=\s*([^;]*).*$)|^.*$/, "$1");

    if (cookieValue != 1) {
        writeCookie('LoggedIn', 1, 15)
    }


</script>



@if (Session::has('swal'))
    @php $session = Session::get('swal'); @endphp
    <script>
        var title = '{{$session['title']}}',
            message = '{{$session['message']}}',
            type = '{{$session['type']}}';

        Swal.fire(
            title,
            message,
            type
        )
    </script>
@endif

<script>

    // addToCart(1, 'sim', 2, 3);
    getCart();

    function getCart() {
        axios.get('/cart/get').then(function (response) {
            clearCart();

            if (response.data.items.length == 0) {
                $('#checkout-cart').hide();
            } else {
                $('#checkout-cart').show();
            }

            $('#cart-counter').text(response.data.items.length );

            for (i = 0; i < response.data.items.length; i++) {
                var item = response.data.items[i];
                var cartItem = `<div class="d-flex align-items-center justify-content-between p-8">\
									<div class="d-flex flex-column mr-2">\
										<a href="#" class="font-weight-bold text-dark-75 font-size-lg text-hover-primary">${item.qty} X ${item.planName}</a>\
										<span class="text-muted">${item.iccid}</span>\

										<div class="d-flex align-items-center mt-2">\

											<a onclick="decreaseQty(${item.id})" class="btn btn-xs btn-light-success btn-icon mr-2">\
												<i class="ki ki-minus icon-xs"></i>\
											</a>\
											<a onclick="increaseQty(${item.id})" class="btn btn-xs btn-light-success btn-icon">\
												<i class="ki ki-plus icon-xs"></i>\
											</a>\
										</div>\
									</div>\
                                       <div class="d-flex flex-column">\
<span class="font-weight-bold mr-1 text-dark-75 font-size-lg text-right">£ ${((item.rate * item.qty) / 100).toFixed(2)}</span>\
                                <span class="text-dark text-right">Scheduled Date <b>${item.scheduled_format}</b></span>\
								</div>\
								</div>`;
                // var cartItem = '<div class="kt-mycart__item"> <div class="kt-mycart__container"> <div class="kt-mycart__info"> <a href="#" class="kt-mycart__title">' + item.planName + '</a> <span class="kt-mycart__desc">' + item.piccid + ' </span> <div class="kt-mycart__action"> <span class="kt-mycart__price">£ ' + (item.rate * item.qty).toFixed(2) + '</span> <span class="kt-mycart__text">for</span> <span class="kt-mycart__quantity">' + item.qty + '</span> <a onclick="decreaseQty(' + i + ')" class="btn btn-label-success btn-icon">&minus;</a> <a onclick="increaseQty(' + i + ')" class="btn btn-label-success btn-icon">&plus;</a> </div> </div> <a href="#" class="kt-mycart__pic"> <img src="' + item.img + '" title=""> </a> </div> </div>';
                $('#cart').append(cartItem);
            }

            $('#cart_total').html('£ ' + (response.data.total / 100).toFixed(2));
            $('#cart_tax').html('£ ' + (response.data.tax / 100).toFixed(2));
            $('#cart_subtotal').html('£ ' + (response.data.subtotal / 100).toFixed(2));
            $('#items').html(response.data.items.length + ' Items');
            $('.cart-number').html(response.data.items.length);
        });
    }

    function emptyCart() {
        axios.get('/cart/clear', {}).then(function (response) {
            getCart();
        });
    }

    function clearCart() {
        $('#cart').empty();
    }

    function increaseQty(id) {
        axios.get('/cart/increase', {
            params: {
                id: id
            }
        }).then(function (response) {
            getCart();
        });
    }

    function decreaseQty(id) {
        axios.get('/cart/decrease', {
            params: {
                id: id
            }
        }).then(function (response) {
            getCart();
        });
    }

    {{--function addToCart(id, type, plan, quantity) {--}}
    {{--    axios.get('/cart/add', {--}}
    {{--        params: {--}}
    {{--            id: id,--}}
    {{--            type: type,--}}
    {{--            plan: plan,--}}
    {{--            quantity: quantity--}}
    {{--        }--}}
    {{--    }).then(function (response) {--}}
    {{--        $('#kt_modal_topup').modal('hide');--}}

    {{--        if (id) {--}}

    {{--            Swal.fire({--}}
    {{--                title: 'Item added to cart!',--}}
    {{--                text: 'You have added a top up to your cart for the following Sim ID: ' + id,--}}
    {{--                type: 'success',--}}
    {{--                showCancelButton: true,--}}
    {{--                cancelButtonText: 'Continue',--}}
    {{--                confirmButtonText: 'Checkout',--}}
    {{--            }).then(function (result) {--}}
    {{--                if (result.value) {--}}
    {{--                    window.location.href = '/checkout';--}}
    {{--                }--}}
    {{--            });--}}
    {{--        } else {--}}

    {{--            Swal.fire({--}}
    {{--                title: 'Item added to cart!',--}}
    {{--                text: 'You have added a top up to your cart for the following Sim ID: ' + '{{$sim ?? ''}}',--}}
    {{--                type: 'success',--}}
    {{--                showCancelButton: true,--}}
    {{--                cancelButtonText: 'Continue',--}}
    {{--                confirmButtonText: 'Checkout',--}}
    {{--            }).then(function (result) {--}}
    {{--                if (result.value) {--}}
    {{--                    window.location.href = '/checkout';--}}
    {{--                }--}}
    {{--            });--}}
    {{--        }--}}
    {{--        getCart();--}}
    {{--    });--}}
    // }

</script>


<!--end::Page Scripts -->

@stack('scripts')

