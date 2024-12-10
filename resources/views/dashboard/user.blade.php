@extends('layouts.layout')
{{--Cart to Basket--}}
@push('content')
    <div class="row">
        <div class="col-xl-6">
            <div class="card card-custom gutter-b" style="height: 136px">
                <!--begin::Body-->
                <div class="card-body py-0 my-8">
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                            <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">
                                Sim Status
                            </a>
                            <span class="font-weight-bold text-muted font-size-lg">The sim cards current status.</span>
                        </div>
                        <div class="d-flex align-items-center">

                            @if ($sim->status)
                                <x-dashboard.user.status-indicator text="Active" icon="success"></x-dashboard.user.status-indicator>
                            @else
                                <x-dashboard.user.status-indicator text="Inactive" icon="danger"></x-dashboard.user.status-indicator>
                            @endif

                            {{--                                <x-dashboard.user.status-indicator text="Waiting for first use" icon="warning"></x-dashboard.user.status-indicator>--}}
                        </div>
                    </div>

                </div>
                <!--end::Body-->
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card card-custom gutter-b" style="height: 136px">
                <!--begin::Body-->
                <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                    <div class="mr-2">
                        <h3 class="font-weight-bolder">Running Low?</h3>
                        <div class="text-dark-50 font-size-lg mt-2">Schedule your next top-up now!</div>
                    </div>
                    <a href="/catalog" class="btn btn-primary font-weight-bold py-3 px-6">View Top-ups</a>
                </div>
                <!--end::Body-->
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card card-custom gutter-b" style="background: #fff;">
                <div class="card-header border-0 pt-5 d-flex justify-content-center" style="min-height: 10px !important; ">
                    <div class="card-label text-center">
                        <h3 class="font-weight-bolder text-dark text-center pt-4">Active Data Summary</h3>
                    </div>
                </div>
                <!--begin::Body-->
                <div class="card-body py-0 my-8">
                    <div class="flex-grow-1">
                        <div class="row m-0 text-center">
                            <div class="col-lg-4 px-8 pb-6">
                                <div style="background: #f68a48; padding-top: 10px; padding-bottom: 10px; width: 220px; border-radius: 10px;margin: 0 auto;">
                                    <div class="font-size-sm text-light font-weight-bold">Total Active Data Limit</div>
                                    <div class="font-size-h3 text-light font-weight-bolder">{{$sim->volume_limit . ' MB'}}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 px-8 pb-6">
                                <div style="background: #1e2252; padding-top: 10px; padding-bottom: 10px; width: 220px; border-radius: 10px;margin: 0 auto;">
                                    <div class="font-size-sm text-light font-weight-bold">Total Active Usage Remaining</div>
                                    <div class="font-size-h3 text-light font-weight-bolder">{{$sim->volume_remaining . ' MB'}}</div>
                                </div>
                            </div>
                            <div class="col-lg-4 px-8 pb-6">
                                <div style="background: #f68a48; padding-top: 10px; padding-bottom: 10px; width: 220px; border-radius: 10px;margin: 0 auto;">
                                    <div class="font-size-sm text-light font-weight-bold"> Total Active Data Used</div>
                                    <div class="font-size-h3 text-light font-weight-bolder">{{$sim->volume . ' MB'}}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-12">

            <div class="card card-custom gutter-b">
                <div class="card-header border-0 py-5">
                    <div class="card-label">
                        <h3 class="card-title font-weight-bolder text-black">Active Loaded Plans</h3>
                    </div>
                    <div class="card-toolbar">

                    </div>
                </div>
                <div class="card-body d-flex flex-column p-5" style="height: 225px" data-scroll="true" data-wheel-propagation="true">
                    <style>
                        th {
                            background: white;
                            position: sticky;
                            top: -20px; /* Don't forget this, required for the stickiness */
                            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
                        }

                        .table-striped tbody tr:nth-of-type(odd) {
                            background-color: #f7f7f7;
                        }
                    </style>
                    
                    @if (!$sim->current_endpoint->getBicsEndpoint() || $sim->current_endpoint->getBicsEndpoint()['resultParam']['resultCode'] == 401)
                        
                        <div style="text-align: center;">
                            Issue Connecting To 3rd Party, Please Try Again Later
                        </div>
                        
                    @else
                    
                    <table class="table table-borderless table-striped">
                        <thead>
                        <tr class="bg-white position-relative zindex-5">
                            <th>Name</th>
                            <th>Validity</th>
                            <th>Usage</th>
                            <th>Start Date</th>
                            <th>Expiry Date</th>
                            <th>Scheduled Date</th>
                            <th>Coverage</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                         
                        @if ( $sim->current_endpoint && count($sim->current_endpoint->getBenefitsFromBics()))
                  
                            @foreach($sim->current_endpoint->benefits_from_bics_formatted as $benefit)
                                <tr>
                                    <td title="{{$benefit->plan->name ?? 'No Plan Name'}}">
                                        {{substr($benefit->plan->name ?? 'No Plan Name', 0, 40).'...'}}
                                    </td>
                                    <td>
                                        {{$benefit->plan->length}} Days
                                    </td>
                                    <td>
                                        {{number_format((collect($benefit['bics'])->sum('actualBalance') - collect($benefit['bics'])->sum('balance')) / 1024 / 1024,0)}} / {{collect($benefit['bics'])->sum('actualBalance') ? number_format(collect($benefit['bics'])->sum('actualBalance') / 1024 / 1024, 0) : $benefit->plan->credit}} MB
                                    </td>
                                    <td>
                                        {{(isset($benefit['bics'][1]) && $benefit['bics'][1]['startDate'] != '-') ? $benefit['bics'][1]['startDate'] : $benefit['bics'][0]['startDate'] ?? ''}}
                                    </td>
                                    <td>
                                        {{(isset($benefit['bics'][1]) && $benefit['bics'][1]['expiryDate'] != '-') ? $benefit['bics'][1]['expiryDate'] : $benefit['bics'][0]['expiryDate'] ?? ''}}
                                    </td>
                                    <td class="position-relative">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                @if ($benefit->scheduled)
                                                    {{$benefit->scheduled}}
                                                @else
                                                    -
                                                @endif
                                            </div>

                                        </div>


                                    </td>
                                    <td>
                                        @if ($benefit->plan && (count($benefit->plan->countries_icons) == 1))
                                            @foreach($benefit->plan->countries_icons as $icon)
                                                <img class="w-25px mx-1" src="/media/{{$icon}}">
                                            @endforeach
                                        @else
                                            <img class="w-25px mx-1" src="/media/svg/flags_round/worldwide.png">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($benefit['bics'][0]['expiryDate'] != '-' || (isset($benefit['bics'][1]) && $benefit['bics'][1]['expiryDate'] != '-'))
                                            <span class="label label-inline label-light-success font-weight-bold">Active</span>
                                        @elseif (($benefit['bics'][0]['expiryDate'] != '-' && \Carbon\Carbon::parse($benefit['bics'][0]['expiryDate']) < \Carbon\Carbon::now()) || (isset($benefit['bics'][1]) && $benefit['bics'][0]['expiryDate'] != '-' && \Carbon\Carbon::parse($benefit['bics'][1]['expiryDate']) < \Carbon\Carbon::now()))
                                            <span class="label label-inline label-light-danger font-weight-bold">Expired</span>
                                        @else
                                            <span class="label label-inline label-light-warning font-weight-bold">Waiting For First Use</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        @foreach(\App\Models\Order::whereIn('status', ['completed','processing'])->get() as $order)
                        @foreach($order->orderItems()->where('sim_id', $sim->id)->where('applied', 0)->orderBy('scheduled')->get() as $item)
                            @if ($item->scheduled)
                                <tr>
                                    <td title="{{$item->plan->name ?? 'No Plan Name'}}">
                                        {{substr($item->plan->name ?? 'No Plan Name', 0, 40).'...'}}
                                    </td>
                                    <td>
                                        {{$item->plan->length}} Days
                                    </td>
                                    <td>
                                        0 / {{round($item->plan->credit / 1000, 2)}} GB
                                    </td>
                                    <td>
                                        -
                                    </td>
                                    <td>
                                        -
                                    </td>
                                    <td class="position-relative">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                {{\Carbon\Carbon::parse($item->scheduled)->format('d/m/Y')}}
                                            </div>
                                            <span class="text-muted font-weight-bold">
                                                    <a class="schedule cursor-pointer" title="Edit">
                                                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                           <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"/>
                                                                    <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                                                    <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                                                </g>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <form class="bm-popover" method="POST" action="/sim/plan/{{$item->id}}/scheduled" style="display: none">
                                                    @csrf
                                                    <div class="input-group">
                                                        <input type="date" name="scheduled" class="form-control" placeholder="Scheduled Date" value="{{str_replace(' 00:00:00', '', $item->scheduled)}}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-success btn-icon" type="submit"><i class="la la-save"></i></button>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-danger btn-icon schedule-close" type="button"><i class="la la-times"></i></button>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </span>
                                        </div>


                                    </td>
                                    <td>
                                        @if (isset($benefit) && (count($benefit->plan->countries_icons) == 1))
                                            @foreach($benefit->plan->countries_icons as $icon)
                                                <img class="w-25px mx-1" src="/media/{{$icon}}">
                                            @endforeach
                                        @else
                                            <img class="w-25px mx-1" src="/media/svg/flags_round/worldwide.png">
                                        @endif
                                    </td>
                                    <td>
                                        <span class="label label-inline label-light-danger font-weight-bold">Scheduled</span>
                                    </td>
                                </tr>

                            @endif
                            @endforeach
                        @endforeach
                
                        
                         @foreach(\App\Models\Benefit::where('sim_id', $sim->id)->where('status', 'queued')->where('linked_benefit', null)->get() as $item)
                         
                         @if(!in_array($item->bics_id, $sim->current_endpoint->getBenefitsFromBics()->pluck('uniqueId')->toArray()))
                         
                            <tr>
                                <td title="{{$item->plan->name ?? 'No Plan Name'}}">
                                    {{substr($item->plan->name ?? 'No Plan Name', 0, 40).'...'}}
                                </td>
                                <td>
                                    {{$item->plan->length}} Days
                                </td>
                                <td>
                                    0 / {{round($item->plan->credit, 0)}} MB
                                </td>
                                <td>
                                    -
                                </td>
                                <td>
                                    -
                                </td>
                                <td class="position-relative">
                                    -


                                </td>
                                <td>
                                    @if (isset($benefit) && (count($benefit->plan->countries_icons) == 1))
                                        @foreach($benefit->plan->countries_icons as $icon)
                                            <img class="w-25px mx-1" src="/media/{{$icon}}">
                                        @endforeach
                                    @else
                                        <img class="w-25px mx-1" src="/media/svg/flags_round/worldwide.png">
                                    @endif
                                </td>
                                <td>
                                    <span class="label label-inline label-light-warning font-weight-bold">Waiting For First Use</span>
                                </td>
                            </tr>
@endif
                        @endforeach
                        
                        @foreach(\App\Models\Benefit::where('sim_id', $sim->id)->where('status', 'cancelled')->where('linked_benefit', null)->get() as $item)
                            <tr>
                                <td title="{{$item->plan->name ?? 'No Plan Name'}}">
                                    {{substr($item->plan->name ?? 'No Plan Name', 0, 40).'...'}}
                                </td>
                                <td>
                                    {{$item->plan->length}} Days
                                </td>
                                <td>
                                
                                    {{$item->volume ?? 0}}/ {{round($item->plan->credit / 1000, 0)}} GB
                                </td>
                                <td>
                                    -
                                </td>
                                <td>
                                    -
                                </td>
                                <td class="position-relative">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            {{\Carbon\Carbon::parse($item->scheduled)->format('d/m/Y')}}
                                        </div>
                                        <span class="text-muted font-weight-bold">
                                                    <a class="schedule cursor-pointer" title="Edit">
                                                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                           <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"/>
                                                                    <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                                                    <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                                                </g>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <form class="bm-popover" method="POST" action="/sim/plan/{{$item->id}}/scheduled" style="display: none">
                                                    @csrf
                                                    <div class="input-group">
                                                        <input type="date" name="scheduled" class="form-control" placeholder="Scheduled Date" value="{{str_replace(' 00:00:00', '', $item->scheduled)}}">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-success btn-icon" type="submit"><i class="la la-save"></i></button>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-danger btn-icon schedule-close" type="button"><i class="la la-times"></i></button>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </span>
                                    </div>


                                </td>
                                <td>
                                    @if (isset($benefit) && (count($benefit->plan->countries_icons) == 1))
                                        @foreach($benefit->plan->countries_icons as $icon)
                                            <img class="w-25px mx-1" src="/media/{{$icon}}">
                                        @endforeach
                                    @else
                                        <img class="w-25px mx-1" src="/media/svg/flags_round/worldwide.png">
                                    @endif
                                </td>
                                <td>
                                    <span class="label label-inline label-light-danger font-weight-bold">Cancelled</span>
                                </td>
                            </tr>

                        @endforeach

                        @foreach(\App\Models\Benefit::where('sim_id', $sim->id)->where('status', 'expired')->where('linked_benefit', null)->get() as $item)
                            <tr>
                                <td title="{{$item->plan->name ?? 'No Plan Name'}}">
                                    {{substr($item->plan->name ?? 'No Plan Name', 0, 40).'...'}}
                                </td>
                                <td>
                                    {{$item->plan->length}} Days
                                </td>
                                <td>
                                    {{number_format($item->plan->credit / 1000, 2)}} / {{round($item->plan->credit / 1000, 0)}} GB
                                </td>
                                <td>
                                    -
                                </td>
                                <td>
                                    -
                                </td>
                                <td class="position-relative">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            -
                                        </div>
                                    </div>


                                </td>
                                <td>
                                    @if (isset($benefit) && (count($benefit->plan->countries_icons) == 1))
                                        @foreach($benefit->plan->countries_icons as $icon)
                                            <img class="w-25px mx-1" src="/media/{{$icon}}">
                                        @endforeach
                                    @else
                                        <img class="w-25px mx-1" src="/media/svg/flags_round/worldwide.png">
                                    @endif
                                </td>
                                <td>
                                    <span class="label label-inline label-light-danger font-weight-bold">Expired</span>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    
                    @endif
                </div>
            </div>

        </div>
        <style>
            .nickname {
                cursor: pointer;
            }

            .bm-popover {
                width: 220px;
                position: absolute;
                box-shadow: 3px 4px 6px 1px #00000091;
                border-radius: 4px;
                top: 41px;
                left: 0px;
                z-index: 9999;
                background: white;
            }
        </style>
        <div class="col-xl-6">
            <div class="card card-custom gutter-b">
                <div class="card-header border-0 py-5">
                    <div class="card-label">
                        <h3 class="card-title font-weight-bolder text-black">Usage Chart</h3>
                    </div>
                    <div class="card-toolbar">
                        <span class="text-muted">Updated Every 20 Minutes</span>
                    </div>
                </div>
                <div class="card-body d-flex flex-column p-0" style="min-height: 252px;">
                    <div id="usage_chart" style="height: 237px; min-height: 237px">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            
            <div class="card card-custom gutter-b">
                <div class="card-header border-0 py-5">
                    <div class="card-label">
                        <h3 class="card-title font-weight-bolder text-black">Usage Breakdown</h3>
                    </div>
                    <div class="card-toolbar">
                        <span class="text-muted">Updated Every 20 Minutes</span>
                    </div>
                </div>
                <div class="card-body d-flex flex-column p-0">
                    @if($sim->breakdown)
                        <div class="card-spacer bg-white rounded-bottom ">
                            <div class="" style="height: 200px;overflow-y: scroll">
                                <table class="table table-borderless table-vertical-center  table-responsive"
                                       style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th class="p-0" style="width: 100px"></th>
                                        <th class="p-0" style="min-width: 150px"></th>
                                        <th class="p-0" style="min-width: 150px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    @foreach($sim->breakdown as $date => $countries)
                                      
                                        @foreach($countries as $country => $operators)
                                          @foreach($operators as $operator => $volume)
                                            @if ($operator !== '')
                                                <tr>
                                             
                                                    <td class="pl-0 py-5">
                                                        <span class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$date}}</span>
                                                    </td>
                                                    <td class="text-right">
                                                            <span class="text-dark font-weight-bold">
                                                                {{number_format($volume / 1024 / 1024, 2)}} MB
                                                                <img src="/media/svg/icons/Files/Cloud-upload.svg"/>
                                                                <img src="/media/svg/icons/Files/Cloud-download.svg"/>
                                                            </span>
                                                    </td>
                                                    <td class="text-center text-dark font-weight-bolder">
                                                        {{$operator}}
                                                    </td>
                                                    <td class="text-right">
                                                            <span class="text-dark font-weight-bold">
                                                                {{$country}}
                                                             
                                                            </span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="card-spacer bg-white rounded-bottom text-center ">

                            <h4 class="d-inline-flex">Waiting for usage breakdown
                            </h4>

                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endpush


{{--@dd($endpoint->breakdownChartFormatted['labels'])--}}
@push('scripts')

    <script>
        $('.schedule').each(function () {
            $(this).click(function () {
                $(this).siblings('.bm-popover').fadeIn(200);
            });
        })

        $('.schedule-close').each(function () {
            $(this).click(function () {
                console.log('test');
                $(this).parent().parent().parent().fadeOut(200);
            });
        })
    </script>

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
            const link = $(this).attr('href');

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


        let usageGraph = function () {

            const element = document.getElementById("usage_chart");
            const height = parseInt(KTUtil.css(element, 'height'));
            const data = {!! json_encode($sim->breakdownChartFormatted['data'] ?? []) !!};
            if (!element) {
                return;
            }

            for (var i = 0; i < data.length; i++) {
                data[i] = parseFloat(data[i]);
            }

            var max = data.reduce(function (a, b) {
                return Math.max(a, b);
            });

            var strokeColor = '#287ED7';

            var options = {
                series: [{
                    name: 'Usage',
                    data: data
                }],
                labels: {!! json_encode($sim->breakdownChartFormatted['labels'] ?? []) !!},
                chart: {
                    type: 'area',
                    height: height,
                    toolbar: false,
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: false
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
                    opacity: 1
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 3,
                    colors: [strokeColor]
                },
                xaxis: {
                    categories: {!! json_encode($endpoint->breakdownChartFormatted['labels'] ?? []) !!},
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: true,
                        style: {
                            colors: KTAppSettings['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTAppSettings['font-family']
                        }
                    },
                    crosshairs: {
                        show: true,
                        position: 'front',
                        stroke: {
                            color: KTAppSettings['colors']['gray']['gray-300'],
                            width: 1,
                            dashArray: 3
                        }
                    }
                },
                yaxis: {
                    forceNiceScale: true,
                    labels: {
                        show: true,
                        style: {
                            colors: KTAppSettings['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTAppSettings['font-family']
                        }
                    }
                },
                grid: {
                    show: false,      // you can either change hear to disable all grids
                    xaxis: {
                        lines: {
                            show: false  //or just here to disable only x axis grids
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false  //or just here to disable only y axis
                        }
                    },
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
                colors: ['#5298df'],
                markers: {
                    colors: [KTAppSettings['colors']['theme']['light']['danger']],
                    strokeColor: [strokeColor],
                    strokeWidth: 3
                }
            };

            var chart = new ApexCharts(element, options);
            chart.render();
        };

        if ($('#usage_chart').length) {
            usageGraph();
        }


    </script>

@endpush
