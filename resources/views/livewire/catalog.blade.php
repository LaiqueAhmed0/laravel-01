<div class="d-flex flex-row w-100">
    <style>
        /* custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;

        }

        ::-webkit-scrollbar-track {
            background: #999;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #f1f1f1;
            border-radius: 10px;
            cursor: pointer;
        }


    </style>
    @if(!$embed)

        {{--        <!--begin::Aside-->--}}
        {{--        <div class="flex-column offcanvas-mobile w-300px w-xl-325px" id="kt_profile_aside">--}}
        {{--            <!--begin::Forms Widget 15-->--}}
        {{--            <div class="card card-custom gutter-b">--}}
        {{--                <!--begin::Body-->--}}
        {{--                <div class="card-body {{$embed ? 'p-0' : ''}}">--}}
        {{--                    <!--begin::Form-->--}}
        {{--                    <div>--}}

        {{--                        <div class="form-group">--}}
        {{--                            <label class="font-size-h3 font-weight-bolder text-dark mb-7">Country</label>--}}
        {{--                            <select wire:model.live="filter.country" class="form-control form-control-solid">--}}
        {{--                                <option value="Search Destinations">--}}
        {{--                                    Search Destinations--}}
        {{--                                </option>--}}
        {{--                                @foreach(\App\Models\Country::orderBy('name')->get() as $country)--}}
        {{--                                    <option value="{{$country->id}}">--}}
        {{--                                        {{$country->name}}--}}
        {{--                                    </option>--}}
        {{--                                @endforeach--}}
        {{--                            </select>--}}
        {{--                        </div>--}}

        {{--                        <!--begin::Categories-->--}}
        {{--                        <div class="form-group mb-11">--}}
        {{--                            <label class="font-size-h3 font-weight-bolder text-dark mb-7">Data</label>--}}
        {{--                            <!--begin::Checkbox list-->--}}
        {{--                            <div class="checkbox-list">--}}
        {{--                                @foreach(\App\Models\Plan::where('type', 'admin')->select('credit')->get()->groupBy('credit') as $plans)--}}
        {{--                                    <label class="checkbox checkbox-lg mb-7">--}}
        {{--                                        <input wire:model.live="filter.credit.{{$plans[0]->credit}}" type="checkbox" value="{{$plans[0]->credit}}"/>--}}
        {{--                                        <span></span>--}}
        {{--                                        <div class="font-size-lg text-dark-75 font-weight-bold">{{$plans[0]->credit / 1000}}GB</div>--}}
        {{--                                        <div class="ml-auto text-muted font-weight-bold">{{count($plans)}}</div>--}}
        {{--                                    </label>--}}
        {{--                                @endforeach--}}

        {{--                            </div>--}}
        {{--                            <!--end::Checkbox list-->--}}
        {{--                        </div>--}}
        {{--                        <!--end::Categories-->--}}
        {{--                        <div class="form-group mb-7">--}}
        {{--                            <label class="font-size-h3 font-weight-bolder text-dark mb-7">Price</label>--}}
        {{--                            <!--begin::Radio list-->--}}
        {{--                            <div class="radio-list">--}}
        {{--                                <label class="radio radio-lg mb-7">--}}
        {{--                                    <input wire:model.live="filter.rate" checked="checked" type="radio" name="price" value="all">--}}
        {{--                                    <span></span>--}}
        {{--                                    <div class="font-size-lg text-dark-75 font-weight-bold">All</div>--}}
        {{--                                    <div class="ml-auto text-muted font-weight-bold">{{\App\Models\Plan::where('type', 'admin')->count()}}</div>--}}
        {{--                                </label>--}}
        {{--                                <label class="radio radio-lg mb-7">--}}
        {{--                                    <input wire:model.live="filter.rate" type="radio" name="price" value="0-1000">--}}
        {{--                                    <span></span>--}}
        {{--                                    <div class="font-size-lg text-dark-75 font-weight-bold">£0 - £10</div>--}}
        {{--                                    <div class="ml-auto text-muted font-weight-bold">{{\App\Models\Plan::where('type', 'admin')->whereBetween('rate', [0, 1000])->count()}}</div>--}}
        {{--                                </label>--}}
        {{--                                <label class="radio radio-lg mb-7">--}}
        {{--                                    <input wire:model.live="filter.rate" type="radio" name="price" value="1001-2000">--}}
        {{--                                    <span></span>--}}
        {{--                                    <div class="font-size-lg text-dark-75 font-weight-bold">£10 - £20</div>--}}
        {{--                                    <div class="ml-auto text-muted font-weight-bold">{{\App\Models\Plan::where('type', 'admin')->whereBetween('rate', [1001, 2000])->count()}}</div>--}}
        {{--                                </label>--}}
        {{--                                <label class="radio radio-lg">--}}
        {{--                                    <input wire:model.live="filter.rate" type="radio" name="price" value="2000-99999">--}}
        {{--                                    <span></span>--}}
        {{--                                    <div class="font-size-lg text-dark-75 font-weight-bold">£20 &amp; Above</div>--}}
        {{--                                    <div class="ml-auto text-muted font-weight-bold">{{\App\Models\Plan::where('type', 'admin')->where('rate', '>' ,2000)->count()}}</div>--}}
        {{--                                </label>--}}
        {{--                            </div>--}}
        {{--                            <!--end::Radio list-->--}}
        {{--                        </div>--}}
        {{--                        --}}
        {{--                    </div>--}}
        {{--                    <!--end::Form-->--}}
        {{--                </div>--}}
        {{--                <!--end::Body-->--}}
        {{--            </div>--}}
        {{--            <!--end::Forms Widget 15-->--}}
        {{--        </div>--}}
        {{--        <!--end::Aside-->--}}

    @endif
    <style>

        @media screen and (max-width: 1000px) {
            .top-section {
                flex-direction: column;
            }
            .top-section .w-50{
                width: 100% !important;
            }
        }

    </style>

    <!--begin::Layout-->
    <div class="flex-row-fluid ml-lg-8" x-data="catalog">
        <!--begin::Card-->
        <div class="card card-custom card-stretch gutter-b {{$embed ? 'w-1200px mx-auto' : ''}}">
            <div class="card-body {{$embed ? 'p-0' : ''}}" style="overflow-x: hidden">
                <div class="d-flex top-section" style="gap:20px">
                    <div class="card card-custom gutter-b {{$embed ? 'w-100' : 'w-50'}}">
                        <div class="card-body rounded p-0 d-flex {{!$embed ? 'bg-light' : ''}}">
                            <div class="d-flex flex-column flex-lg-row-auto {{$embed ? 'w-100' : 'w-100 w-lg-350px w-xl-450px w-xxl-650px py-10 py-md-14'}} max-w-100 px-10 px-md-20 {{!$embed ? 'pr-lg-0' : ''}}">
                                <div wire:ignore class="d-flex flex-center py-2 px-6">
                                    {{--<input type="text" wire:model.live="search" class="form-control border-0 font-weight-bold pl-2" placeholder="Search...">--}}
                                    <div style="max-width: 100%">
                                        <label class="w-100 d-block" style="{{$embed ? 'color:white;' : 'color:black;'}}">
                                            Pre-Made Plans By Country
                                        </label>
                                        <select id="countrySelect" wire:model.live="filter.country" data-control="select2" class="form-control">
                                            <option value="all">
                                                Search Countries...
                                            </option>
                                            @foreach(\App\Models\Country::orderBy('name')->where('operators', '!=', '[]')->get() as $country)
                                                <option value="{{$country->id}}" dataflag="{{$country->icon}}">
                                                    {{$country->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button wire:click="resetFilters" class="btn btn-primary font-weight-bolder ml-4 px-8">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!$embed)
                        <!--<div class="card card-custom gutter-b w-50">-->
                        <!--    <div class="card-body rounded p-0 d-flex {{!$embed ? 'bg-light' : ''}}">-->
                        <!--        <div class="d-md-flex flex-row-fluid bgi-no-repeat bgi-position-y-center bgi-position-x-left bgi-size-cover align-items-center py-10 px-10 justify-content-between">-->
                        <!--            <h2 class="text-dark font-weight-bold my-2" style="    font-size: 18px;">Create your personalised plan, with custom allowance and validity</h2>-->
                        <!--            <a href="/catalog/custom" data-toggle="tooltip" data-html="true" title="<span class='font-size-lg'>Click here to customise your data plan.</span>" class="btn btn-info">Custom Plan</a>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                    @endif
                </div>

                <!--begin::Section-->
                <div class="row">
                    <div class="col-sm-12 {{$embed ? '' : 'table-striped'}}">

                        <div class="table-responsive">
                            <table class="table {{$embed ? '' : 'table-borderless'}} table-vertical-center catalogtable">
                                <thead>
                                <tr>
                                    <th class="p-0 w-40px">Plan</th>
                                    <th class="min-w-200px"></th>
                                    <th class="min-w-80px text-center">Allowance</th>
                                    <th class="min-w-125px text-center">Validity</th>
                                    <th wire:ignore class="min-w-125px text-center" data-toggle="tooltip" data-html="true" title="<span class='font-size-lg'>Customise the validity period and the data size to your preference</span>">Customisable <i style="font-size: 20px;color: #fe328d;" class="flaticon2-information"></i></th>
                                    <th class="min-w-80px text-center">Networks</th>
                                    <th class="min-w-80px text-right"><i class="flaticon2-shopping-cart-1 icon-lg"></i></th>
                                    @if(!$embed)
                                        <th class="min-w-20px"></th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="pl-0 py-4 px-4">
                                            <div class="d-flex justify-content-start">
                                                @if($product->featured)
                                                    <i style="color: gold;" class="la la-star icon-2x"></i>
                                                @elseif ((count($product->getCountries()) == 1))
                                                    @foreach($product->getCountries() as $country)
                                                        <img class="w-25px mx-1" src="/media/{{$country->icon}}">
                                                    @endforeach
                                                @else
                                                    <img class="w-25px mx-1" src="/media/svg/flags_round/worldwide.png">
                                                @endif
                                            </div>
                                        </td>
                                        <td class="">
                                            <span class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$product->name}}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{$product->credit / 1000}} GB</span>
                                        </td>
                                        <td class="text-center">
                                            <span class=" text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$product->length}} days</span>
                                        </td>
                                        <td class="text-center">
                                            @if (!$product->hybrid)
                                                <span class="svg-icon svg-icon-info svg-icon-2x">
                                                   <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                                            <path d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002) "/>
                                                        </g>
                                                    </svg>
                                                </span>
                                            @else
                                                <i class="flaticon2-cross text-info"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <i data-toggle="tooltip" data-html="true" title="<span class='font-size-lg'>Click here to view networks included in the plan.</span>" class="flaticon2-information network-click text-dark-75 font-weight-bolder text-hover-primary mb-1 icon-2x cursor-pointer "></i>
                                            <div class="network-popup" style="display: none">
                                                <div>
                                                    <h3 class="pb-5">Networks Coverage</h3>
                                                    <span class="network-close">
                                                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                           <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                                                        <rect x="0" y="7" width="16" height="2" rx="1"/>
                                                                        <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </span>
                                                    </span>
                                                    <table>
                                                        @foreach($product->getNetworks() as $network)
                                                            <tr>
                                                                <td>{{$network['country']}}</td>
                                                                <td>{{$network['name']}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <span data-toggle="tooltip" data-html="true" title="<span class='font-size-lg'>Add to basket</span>" onclick="window.top.location.href = 'https://portal.lovemobiledata.com/catalog?addtocart={{$product->id}}';" class="label label-xl font-weight-boldest w-auto label-rounded label-danger cursor-pointer" style="width: 84px !important;padding: 10px; font-size: 16px; line-height: 1; height: 30px; background: #f69242;">£{{number_format(($product->pricing / 100), 2)}}</span>


                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-12">

                        <em class="text-center w-100 d-block {{$embed ? 'text-light' : 'text-dark'}} font-size-lg">The promotional European & North American data allowance is limited to 70% capacity when used only in North America</em>
                    </div>
                </div>
                <!--end::Section-->
            </div>
            @if(!$embed)
                <div class="d-block w-100 text-center my-15">
                    <img class="d-inline-block h-50px" src="/media/200px-Mastercard-logo.svg.png">
                    <img class="d-inline-block h-50px" src="/media/220px-Maestro_2016.svg.png">
                    <img class="d-inline-block h-50px" src="/media/visa-ac7ab8356844bc9b5282bb09ea21d2e3.svg">
                    <img class="d-inline-block h-50px mr-2" src="/media/amex.png">
                    <img class="d-inline-block h-50px mr-2" src="/media/apple.png">
                    <img class="d-inline-block h-50px" src="/media/google-pay.png">
                </div>
            @endif
        </div>
        <!--end::Card-->


    </div>
    <!--end::Layout-->

    @if($embed)
        <style>
            body, .card {
                background: transparent !important;
            }

            .table {
                color: #fff;
            }

            td .text-dark-75 {
                color: white !important;
                font-size: 18px;
                font-weight: normal !important;
            }

            td:hover .text-dark-75 {
                color: white !important;
            }

            table thead th {
                font-size: 18px !important;
            }

            .table th, .table td {
                padding: 1.2rem;
            }
        </style>
    @endif

    <style>
        .img-flag {
            width: 25px;
            margin-right: 10px;
        }

        .select2-container {
            width: 800px !important;
        }

        .select2-container {
            max-width: 100% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding: 16px;
            font-size: 16px;
        }

        .content {
            padding-top: 0 !important;
        }

        .network-popup {
            background: #00000030;
            color: black;
            display: flex;
            position: fixed;
            padding: 20px;
            border-radius: 20px;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            justify-content: center;
            cursor: pointer;
            z-index: 999;
        }

        .network-popup > div {
            background: white;
            height: 350px;
            margin-top: 10%;
            padding: 20px;
            padding-top: 50px;
            border-radius: 10px;
            overflow-y: scroll;
            position: relative;

        }

        .network-popup > div table {
            width: 500px;
            max-width: 100%;
        }

        span.network-close {
            position: absolute;
            top: 10px;
            right: 10px;
        }

    </style>




    @if (Auth::check())
        <!-- Modal-->
        <div class="modal fade" id="addToCart" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select SIM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Scheduled Date</label>
                            <div class="input-group date">
                                <input type="date" class="form-control " name="date">
                            </div>

                        </div>
                        <div data-scroll="true" data-height="200">
                            @if (isset($sims))
                                @foreach($sims as $sim)
                                    <div class="d-flex align-items-center justify-content-between mb-5">
                                        <div class="d-flex flex-column">
                                            <span class="text-dark font-weight-bolder font-size-lg">{{$sim->iccid}}</span>
                                            <span class="text-muted">{{$sim->nickname}}</span>
                                        </div>
                                        <div>
                                            <button class="btn btn-info btn-sm selectSim" data-iccid="{{$sim->iccid}}">Select</button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

    @endif

    <style>
        @media screen and (max-width: 600px) {

            .catalogtable {
                padding: 20px;
                display: block;
            }

            .catalogtable > thead {
                display: none;
            }

            .catalogtable > tbody > tr > td {
                display: flex;
            }

            .catalogtable > tbody > tr > td {
                border-top: none;
                padding-top: 5px;
                padding-bottom: 5px;
            }

            .catalogtable > tbody > tr > td .text-dark-75 {
                font-size: 14px !important;
            }

            .catalogtable > tbody > tr {
                margin-bottom: 20px;
                border: 1px solid #585858;
                display: block;
                border-radius: 20px;
                background: #545454;
                padding-bottom: 10px;
            }

            @if(!$embed)
                    .catalogtable > tbody > tr {
                border: 1px solid #f2f6f9 !important;
                background: #f2f6f9 !important;

            }
            @endif

                .catalogtable > tbody > tr > td::before {
                content: attr(label);
                font-weight: bold;
                width: 120px;
                min-width: 120px;
                text-align: left;
                font-size: 14px;
                line-height: 1;
            }
        }
    </style>
    @script
    <script>

        Alpine.data('catalog', () => {
            return {
                currentPlan: null,
                currentIccid: null,
                labels() {
                    const tableEl = document.querySelector('table');
                    const thEls = tableEl.querySelectorAll('thead th');
                    const tdLabels = Array.from(thEls).map(el => el.innerText);

                    tableEl.querySelectorAll('tbody tr').forEach(tr => {
                        Array.from(tr.children).forEach(
                            (td, ndx) => td.setAttribute('label', tdLabels[ndx])
                        );
                    });

                },
                matchStart(params, data) {
                    // If there are no search terms, return all of the data
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    // Do not display the item if there is no 'text' property
                    if (typeof data.text === 'undefined') {
                        return null;
                    }

                    if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                        return true;
                    }

                    return false;
                },
                formatState(state) {
                    if (!state.id || !$(state.element).attr('dataflag')) {
                        return state.text;
                    }

                    var baseUrl = "/media/";
                    var $state = $(
                        '<span><img src="' + baseUrl + '' + $(state.element).attr('dataflag') + '" class="img-flag" /> ' + state.text + '</span>'
                    );
                    return $state;
                },
                addToCart() {
                    let scheduled = $('[name="date"]').val();

                    if (this.currentPlan && this.currentIccid) {
                        axios.get('/cart/add', {
                            params: {
                                iccid: this.currentIccid,
                                plan: this.currentPlan,
                                scheduled
                            }
                        }).then(function (response) {
                            $('#addToCart').modal('hide');

                            Swal.fire({
                                title: 'Item added to cart!',
                                text: 'You have added a top up to your cart for the following Sim ID: ' + currentIccid,
                                type: 'success',
                                showCancelButton: true,
                                cancelButtonText: 'Continue',
                                confirmButtonText: 'Checkout',
                            }).then(function (result) {
                                if (result.value) {
                                    window.location.href = '/checkout';
                                }
                            });

                            getCart();

                        });
                    }
                },
                init() {

                    queryString = window.location.search,
                        urlParams = new URLSearchParams(queryString),
                        item = urlParams.get('addtocart'),

                        this.labels();

                    if (item) {
                        this.currentPlan = item;
                        $('#addToCart').modal("show");
                    }

                    $('.addplan').click(function () {
                        this.currentPlan = $(this).attr('data-id');
                        $('#addToCart').modal("show");
                    });



                    $('.selectSim').click( (e) => {
                        this.currentIccid = $(e.target).attr('data-iccid');

                        this.addToCart();
                    });

                    $('body').on('click', '.network-click', function () {
                        $(this).siblings('.network-popup').fadeIn();
                    })

                    $('body').on('click', '.network-close', function () {
                        $('.network-popup').fadeOut();
                    })

                    $('body').on('click', '.network-popup', function () {
                        $('.network-popup').fadeOut();
                    })

                    $('#countrySelect').select2({
                        templateResult: this.formatState,
                        // matcher: matchStart
                    });

                    this.$wire.on('select2', () => {
                        this.labels();
                        $('[data-toggle="tooltip"]').tooltip()
                        $('#countrySelect').select2({
                            templateResult: this.formatState,
                            // matcher: matchStart
                        });
                    });

                    $('#countrySelect').change(() => {
                        let data = $('#countrySelect').select2('data');

                        this.$wire.dispatch('countryUpdated', {country: data[0].id})
                    });
                }
            }
        })

    </script>
    @endscript






