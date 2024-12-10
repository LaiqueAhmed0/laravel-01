@extends('layouts.layout')

@push('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-custom card-stretch mb-5">
                <div class="card-header border-bottom-0 d-flex align-items-center">
                    <div class="card-label">
                        <h3 class="card-title">
                            Selected Sim Top-up Status:
                        </h3>
                        <span class="text-muted">{{$endpoint->iccid}}</span>
                    </div>

                    <div class="card-toolbar">
                        <button data-id="{{$endpoint->id}}" data-piccid="{{$endpoint->iccid}}" data-toggle="modal"
                                data-target="#kt_modal_topup" class="btn btn-sm btn-success font-weight-bold">
                            <i class="fa fa-arrow-alt-circle-up"></i> Top-up
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($endpoint->status !== 'Active')
                        <div class="kt-widget12__content">
                            <h4 class="text-center p-10 font-weight-bolder">No Active Top-up Information</h4>
                        </div>
                    @else
                        <div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-8 d-flex flex-column">
                                        <span class="text-dark font-weight-bold mb-4">Data Plan</span>
                                        <span class="text-muted font-weight-bolder font-size-lg">{{$endpoint->plan->planName}}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-8 d-flex flex-column">
                                        <span class="text-dark font-weight-bold mb-4">Start Date</span>
                                        <span class="text-muted font-weight-bolder font-size-lg">{{$endpoint->getBenefitDates()['from']->format('d/m/Y') ?? 'Not Started'}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-8 d-flex flex-column">
                                        <span class="text-dark font-weight-bold mb-4">Status</span>
                                        <span class="text-muted font-weight-bolder font-size-lg text-capitalize">{{$endpoint->status}}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-8 d-flex flex-column">
                                        <span class="text-dark font-weight-bold mb-4">Expiry Date</span>
                                        <span class="text-muted font-weight-bolder font-size-lg">{{$endpoint->getBenefitDates()['to']->format('d/m/Y') ?? 'Not Started'}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-custom mb-5">
                <div class="card-header">
                    <h3 class="card-title">Previous Top-ups</h3>
                </div>
                <div class="card-body">
                    <table class="table" id="previous">
                        <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Order ID</th>
                            <th>Date Ordered</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($endpoint->getPreviousTopups() as $topup)
                            <tr>
                                <td>{{$topup->plan}}</td>
                                <td><a href="/profile/orders/{{$topup->order_id}}">{{$topup->order_id_formatted}}</a> </td>
                                <td>{{$topup->created_at_formatted}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">Queued Top-ups</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Order ID</th>
                            <th>Date Ordered</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($endpoint->getScheduledTopups() as $topup)
                            <tr>
                                <td>{{$topup->plan}}</td>
                                <td><a href="/profile/orders/{{$topup->order_id}}">{{$topup->order_id_formatted}}</a> </td>
                                <td>{{$topup->created_at_formatted}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endpush

@push('scripts')

    <script>

        $(document).ready(async function () {
            let plans = [];

            await $.get('api/plans', {}, function (res) {
                    plans = res;
                }
            );
        });

        $('body').on('click', '.top-up-addtocart', function () {
            var piccid = "{{$endpoint->iccid}}"
            var plan = $(this).attr('data-plan');

            addToCart(piccid, 'sim', plan, 1);
        });

    </script>

    <style>
        .inner h2 {
            font-weight: 500;
            font-size: 2.5rem;
        }

        .datatable-row {
            cursor: pointer;
        }

        .inner .fa {
            color: #357ABE;
        }

    </style>

    <div class="modal fade" id="kt_modal_topup" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Top-up for the Sim ID: <span>{{$endpoint->iccid}}</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="d-flex justify-content-between">
                        @foreach ($plans as $plan)
                            <div class="d-inline-block" style="min-height: 250px; width: 25%; text-align: center;">
                                <img src="{{$plan->image}}" style="margin-bottom: 20px;width: 100%; max-width: 120px;">
                                <h2 style="color: #444;">{{$plan->name}}</h2>
                                <h4 style="color: #444;"><strong>£{{$plan->rate / 100}} ex VAT</strong></h4>
                                <button style="margin-top: 30px;" type="button" data-plan="{{$plan->id}}" class="btn btn-wide btn-outline-primary btn-elevate btn-elevate-air top-up-addtocart">
                                    Add to Cart
                                </button>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>

@endpush
