@extends('layouts.layout')

@push('content')

    <div class="row">

        <div class="col-xl-6">
            <!--begin::Base Table Widget 1-->
            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">Sim Card</span>

                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-2 pb-0 mt-n3">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table table-borderless table-vertical-center">
                            <thead>
                            <tr>
                                <th class="p-0 min-w-200px"></th>
                                <th class="p-0 min-w-100px"></th>
                                <th class="p-0 min-w-40px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class=" px-6">
                                <td class="py-6 pl-0">
                                    <a href="#" class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$endpoint->iccid}}</a>
                                    <span class="text-muted font-weight-bold d-block">Iccid</span>
                                </td>
                                <td>
                                    @php $usagePercent = isset($subscription['balance']) ? (($usage->dataTotalUsage->totalVolume / ($subscription['balance'] / 1024 / 1024)) * 100) : null @endphp
                                    <div class="d-flex flex-column w-100 mr-2">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="text-muted mr-2 font-size-sm font-weight-bold">{{$usagePercent ? $usagePercent . '%' : 'No Plan'}}</span>
                                            <span class="text-muted font-size-sm font-weight-bold">Usage</span>
                                        </div>
                                        <div class="progress progress-xs w-100">
                                            <div class="progress-bar
                                                @if($usagePercent < 80)
                                                    bg-brand
                                                @elseif($usagePercent < 90)
                                                    bg-warning
                                                @else
                                                    bg-danger
                                                @endif
                                                    " role="progressbar" style="width: {{ ($usagePercent > 100) ? 100 : $usagePercent}}%;" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--end::Table-->

                </div>
            </div>
            <!--end::Base Table Widget 1-->

            <div class="card card-custom gutter-b">
                <!--begin::Body-->
                <div class="card-body d-flex align-items-center py-0 my-8">
                    <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">Subscription Status</a>
                        <span class="font-weight-bold text-muted font-size-lg">The sim cards current subscription status.</span>
                    </div>
                    <div class="d-flex align-items-center">
                        @if (!isset($subscription))
                            <h4 class="text-danger mr-5 font-weight-bolder mb-0">Inactive</h4>
                            <div class="symbol symbol-light-danger mr-3">
                                <span class="symbol-label svg-icon svg-icon-danger svg-icon-2x">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                                <rect x="0" y="7" width="16" height="2" rx="1"/>
                                                <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                            </div>
                        @elseif ($subscription['expiryDate'] == '-')
                            <h4 class="text-warning mr-5 font-weight-bolder mb-0">Waiting for first use</h4>
                            <div class="symbol symbol-light-warning mr-3">
                                <span class="symbol-label svg-icon svg-icon-warning svg-icon-2x">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M19.5,10.5 L21,10.5 C21.8284271,10.5 22.5,11.1715729 22.5,12 C22.5,12.8284271 21.8284271,13.5 21,13.5 L19.5,13.5 C18.6715729,13.5 18,12.8284271 18,12 C18,11.1715729 18.6715729,10.5 19.5,10.5 Z M16.0606602,5.87132034 L17.1213203,4.81066017 C17.7071068,4.22487373 18.6568542,4.22487373 19.2426407,4.81066017 C19.8284271,5.39644661 19.8284271,6.34619408 19.2426407,6.93198052 L18.1819805,7.99264069 C17.5961941,8.57842712 16.6464466,8.57842712 16.0606602,7.99264069 C15.4748737,7.40685425 15.4748737,6.45710678 16.0606602,5.87132034 Z M16.0606602,18.1819805 C15.4748737,17.5961941 15.4748737,16.6464466 16.0606602,16.0606602 C16.6464466,15.4748737 17.5961941,15.4748737 18.1819805,16.0606602 L19.2426407,17.1213203 C19.8284271,17.7071068 19.8284271,18.6568542 19.2426407,19.2426407 C18.6568542,19.8284271 17.7071068,19.8284271 17.1213203,19.2426407 L16.0606602,18.1819805 Z M3,10.5 L4.5,10.5 C5.32842712,10.5 6,11.1715729 6,12 C6,12.8284271 5.32842712,13.5 4.5,13.5 L3,13.5 C2.17157288,13.5 1.5,12.8284271 1.5,12 C1.5,11.1715729 2.17157288,10.5 3,10.5 Z M12,1.5 C12.8284271,1.5 13.5,2.17157288 13.5,3 L13.5,4.5 C13.5,5.32842712 12.8284271,6 12,6 C11.1715729,6 10.5,5.32842712 10.5,4.5 L10.5,3 C10.5,2.17157288 11.1715729,1.5 12,1.5 Z M12,18 C12.8284271,18 13.5,18.6715729 13.5,19.5 L13.5,21 C13.5,21.8284271 12.8284271,22.5 12,22.5 C11.1715729,22.5 10.5,21.8284271 10.5,21 L10.5,19.5 C10.5,18.6715729 11.1715729,18 12,18 Z M4.81066017,4.81066017 C5.39644661,4.22487373 6.34619408,4.22487373 6.93198052,4.81066017 L7.99264069,5.87132034 C8.57842712,6.45710678 8.57842712,7.40685425 7.99264069,7.99264069 C7.40685425,8.57842712 6.45710678,8.57842712 5.87132034,7.99264069 L4.81066017,6.93198052 C4.22487373,6.34619408 4.22487373,5.39644661 4.81066017,4.81066017 Z M4.81066017,19.2426407 C4.22487373,18.6568542 4.22487373,17.7071068 4.81066017,17.1213203 L5.87132034,16.0606602 C6.45710678,15.4748737 7.40685425,15.4748737 7.99264069,16.0606602 C8.57842712,16.6464466 8.57842712,17.5961941 7.99264069,18.1819805 L6.93198052,19.2426407 C6.34619408,19.8284271 5.39644661,19.8284271 4.81066017,19.2426407 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                        </g>
                                    </svg>
                                </span>
                            </div>
                        @else
                            <h4 class="text-success mr-5 font-weight-bolder mb-0">Active</h4>
                            <div class="symbol symbol-light-success mr-3">
                                <span class="symbol-label svg-icon svg-icon-success svg-icon-2x">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002) "/>
                                        </g>
                                    </svg><!--end::Svg Icon-->
                                </span>
                            </div>
                        @endif


                    </div>
                </div>
                <!--end::Body-->
            </div>

            <div class="card card-custom gutter-b">
                <div class="card-body d-flex align-items-center py-0 my-8">
                    <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">User Status</a>
                        <span class="font-weight-bold text-muted font-size-lg">Current user that has claimed the sim</span>
                    </div>
                    <h4 class="text-{{$endpoint->claimed_by == 'Not Claimed' ? 'danger' : 'success'}} mr-5 font-weight-bolder mb-0">{{$endpoint->claimed_by}}</h4>
                    @if($endpoint->claimed_by == 'Not Claimed')
                        <div class="symbol symbol-light-danger mr-3">
                            <span class="symbol-label svg-icon svg-icon-danger svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                            <rect x="0" y="7" width="16" height="2" rx="1"/>
                                            <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                        </div>
                    @else
                        <div class="symbol symbol-light-success mr-3">
                            <span class="symbol-label svg-icon svg-icon-success svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002) "/>
                                    </g>
                                </svg><!--end::Svg Icon-->
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card card-custom gutter-b">
                <div class="card-body d-flex align-items-center py-0 my-8">
                    <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">Retailer Status</a>
                        <span class="font-weight-bold text-muted font-size-lg">Current retailer that owns the sim</span>
                    </div>
                    <h4 class="text-{{$endpoint->retailer == 'No Retailer' ? 'danger' : 'success'}} mr-5 font-weight-bolder mb-0">{{$endpoint->retailer}}</h4>
                    @if($endpoint->retailer == 'No Retailer')
                        <div class="symbol symbol-light-danger mr-3">
                            <span class="symbol-label svg-icon svg-icon-danger svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                            <rect x="0" y="7" width="16" height="2" rx="1"/>
                                            <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                        </div>
                    @else
                        <div class="symbol symbol-light-success mr-3">
                            <span class="symbol-label svg-icon svg-icon-success svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002) "/>
                                    </g>
                                </svg><!--end::Svg Icon-->
                            </span>
                        </div>
                    @endif
                </div>
            </div>

        </div>
        <div class="col-xl-6">
            <div class="card card-custom gutter-b card-stretch" style="background: #3699FF ">
                <div class="card-header border-0 py-5">
                    <div class="card-label">
                        <h3 class="card-title font-weight-bolder text-white">Usage</h3>
                        <span class="text-white font-weight-bold font-size-lg">{{$endpoint->iccid}}</span>
                    </div>
                </div>
                <div class="card-body d-flex flex-column p-0">
                    <div id="usage_chart" style="height: 200px; min-height: 200px">

                    </div>
                    <div class="card-spacer bg-white flex-grow-1">
                        <div class="row m-0">
                            <div class="col px-8 py-6 mr-8">
                                <div class="font-size-sm text-muted font-weight-bold">Current Plan</div>
                                <div class="font-size-h4 font-weight-bolder">{{!isset($subscription) ? 'No Plan' : (($subscription['balance'] / 1024 / 1024) . ' MB Plan')}}</div>
                            </div>
                            <div class="col px-8 py-6">
                                <div class="font-size-sm text-muted font-weight-bold">Usage Limit</div>
                                <div class="font-size-h4 font-weight-bolder">{{!isset($subscription) ? 'No Plan' : (($subscription['balance'] / 1024 / 1024) . ' MB')}}</div>
                            </div>
                        </div>

                        <div class="row m-0">
                            <div class="col px-8 py-6 mr-8">
                                <div class="font-size-sm text-muted font-weight-bold">Usage Remaining</div>
                                <div class="font-size-h4 font-weight-bolder">{{ !isset($subscription) ? 'No Plan' : (($subscription['balance'] / 1024 / 1024) - $usage->dataTotalUsage->totalVolume)}}
                                    MB
                                </div>
                            </div>
                            <div class="col px-8 py-6">
                                <div class="font-size-sm text-muted font-weight-bold">Usage</div>
                                <div class="font-size-h4 font-weight-bolder">{{ $usage->dataTotalUsage->totalVolume}}
                                    MB
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-spacer bg-white rounded-bottom ">
                        <h3 class="text-center font-weight-bolder">Breakdown</h3>
                        @if ($usage !== null)
                            <div class="scroll scroll-pull ps ps--active-y" data-scroll="true" style="height: 200px;overflow: hidden">
                                <table class="table table-borderless table-vertical-center" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th class="p-0" style="width: 100px"></th>
                                        <th class="p-0" style="min-width: 150px"></th>
                                        <th class="p-0" style="min-width: 150px"></th>
                                        <th class="p-0" style="min-width: 100px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($usage->dataUsage as $dataUsage)
                                        <tr>
                                            <td class="pl-0 py-5">
                                                <span class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$dataUsage->date}}</span>
                                            </td>
                                            <td class="text-right">
                                                <span class="text-muted font-weight-bold">
                                                    {{$dataUsage->uplink}} MB <img src="/media/svg/icons/Files/Cloud-upload.svg"/>
                                                </span>
                                            </td>
                                            <td class="text-right">
                                                <span class="text-muted font-weight-bold">
                                                    {{$dataUsage->downlink}} MB <img src="/media/svg/icons/Files/Cloud-download.svg"/>
                                                </span>
                                            </td>
                                            <td class="text-right pr-0">
                                                <span class="text-dark-75 font-weight-bolder font-size-lg">{{$dataUsage->totalVolume}} MB</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>


                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endpush

@push('scripts')
    <script>

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
        });

        $('#simDelete').click(function (e) {
            e.preventDefault();
            var link = $(this).attr('href');

            swalWithBootstrapButtons.fire({
                title: 'Are you sure you want to remove the current sim?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.value) {
                    window.location.href = link;
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {

                }
            });

        });


        $('#simSelect').change(function () {
            var urlParams = parseURLParams(window.location.href);
            if (urlParams && urlParams['to']) {
                window.location.href = "/dashboard?sim=" + $(this).val() + '&to=' + urlParams['to'];
            } else {
                window.location.href = "/dashboard?sim=" + $(this).val();
            }
        });

        function parseURLParams(url) {
            var queryStart = url.indexOf("?") + 1,
                queryEnd = url.indexOf("#") + 1 || url.length + 1,
                query = url.slice(queryStart, queryEnd - 1),
                pairs = query.replace(/\+/g, " ").split("&"),
                parms = {}, i, n, v, nv;

            if (query === url || query === "") return;

            for (i = 0; i < pairs.length; i++) {
                nv = pairs[i].split("=", 2);
                n = decodeURIComponent(nv[0]);
                v = decodeURIComponent(nv[1]);

                if (!parms.hasOwnProperty(n)) parms[n] = [];
                parms[n].push(nv.length === 2 ? v : null);
            }
            return parms;
        }

    </script>

    <script>

        var usageGraph = function () {
            var element = document.getElementById("usage_chart");
            var height = parseInt(KTUtil.css(element, 'height'));
            var data = {!! json_encode($chart['data']) !!};

            if (!element) {
                return;
            }

            for (var i = 0; i < data.length; i++) {
                data[i] = parseFloat(data[i]);
            }

            var strokeColor = '#287ED7';

            var options = {
                series: [{
                    name: 'Usage',
                    data: data
                }],
                chart: {
                    type: 'area',
                    height: height,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    },
                    dropShadow: {
                        enabled: true,
                        enabledOnSeries: undefined,
                        top: 5,
                        left: 0,
                        blur: 3,
                        color: strokeColor,
                        opacity: 0.5
                    }
                },
                plotOptions: {},
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'solid',
                    opacity: 0
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 3,
                    colors: [strokeColor]
                },
                xaxis: {
                    categories: {!! json_encode($chart['labels']) !!},
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            colors: KTAppSettings['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTAppSettings['font-family']
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            color: KTAppSettings['colors']['gray']['gray-300'],
                            width: 1,
                            dashArray: 3
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: 40,
                    labels: {
                        show: false,
                        style: {
                            colors: KTAppSettings['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTAppSettings['font-family']
                        }
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px',
                        fontFamily: KTAppSettings['font-family']
                    },
                    y: {
                        formatter: function (val) {
                            return val + " MB"
                        }
                    },
                    marker: {
                        show: false
                    }
                },
                colors: ['transparent'],
                markers: {
                    colors: [KTAppSettings['colors']['theme']['light']['danger']],
                    strokeColor: [strokeColor],
                    strokeWidth: 3
                }
            };

            var chart = new ApexCharts(element, options);
            chart.render();
        };
        usageGraph();
    </script>


@endpush
