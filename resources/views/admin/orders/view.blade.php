@extends('layouts.layout')


@push('content')
    <div class="d-flex flex-row w-100" >
        <div class="card card-custom w-100">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Order: {{$order->id_formatted}}</span>
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">view order details</span>
                </h3>
                <div class="card-toolbar">
                    <span class="label label-info label-inline text-capitalize font-size-lg font-weight-bold">{{$order->status}}</span>
                    @if ($order->status == 'pending')
                        <a class="btn btn-danger btn-sm ml-3" href="/admin/orders/{{$order->id}}/update-status/cancelled">
                            Cancel Order
                        </a>
                        <a class="btn btn-success btn-sm ml-3" href="/admin/orders/{{$order->id}}/update-status/completed">
                            Process Order
                        </a>
                    @endif
                    @if ($order->status == 'completed')
                        <a class="btn btn-danger btn-sm ml-3" href="/admin/orders/{{$order->id}}/update-status/refund">
                            Refund
                        </a>
                    @endif
                    <a class="btn btn-primary btn-sm ml-3" href="/admin/orders/{{$order->id}}/invoice">
                        View Invoice
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <table class="table">
                            <tr>
                                <th>First Name</th>
                                <td>{{$order->first_name}}</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>{{$order->last_name}}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{$order->phone}}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{$order->email}}</td>
                            </tr>
                            <tr>
                                <th>Company Name</th>
                                <td>{{$order->company_name}}</td>
                            </tr>
                            <tr>
                                <th>Tax Code</th>
                                <td>{{$order->tax_code}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <table class="table">
                            <tr>
                                <th>Address 1</th>
                                <td>{{$order->address_1}}</td>

                            </tr>
                            <tr>
                                <th>Address 2</th>
                                <td>{{$order->address_2}}</td>
                            </tr>
                            <tr>
                                <th>Postcode</th>
                                <td>{{$order->postcode}}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{$order->city}}</td>
                            </tr>
                            <tr>
                                <th>State/County</th>
                                <td>{{$order->county}}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{getCountry($order->country)}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row" style="margin-top: 30px;">
                    <div class="col-sm-12">
                        <table class="table">
                            <thead style="border-bottom: 2px solid #7a7a7a">
                            <tr>
                                <th>Data Plan</th>
                                <th>Sim ID</th>
                                <th>Length</th>
                                <th class="text-right">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-right">Total</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach ($order->getOrderItems() as $item)
                                <tr>
                                    <td>
                                        {{getPlanName($item->plan_id)}}
                                        @if ($item->scheduled)
                                        | Scheduled For: {{Carbon\Carbon::parse($item->scheduled)->format('d/m/Y')}}
                                        @endif
                                        </td>
                                    <td>{{$item->iccid}}</td>
                                    <td>{{$item->plan->length}} days</td>
                                    <td class="text-right">£ {{number_format($item->price / 100, 2)}}</td>
                                    <td class="text-center">{{$item->quantity}}</td>
                                    <td class="text-right">£ {{number_format(($item->price * $item->quantity) / 100, 2)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr style="border-top: 2px solid #7a7a7a">
                                <td colspan="4"></td>
                                <th>Subtotal</th>
                                <td class="text-right">£ {{number_format($order->subtotal  / 100, 2)}}</td>
                            </tr>
                            <tr>
                                <td style="border-top: 0" colspan="4"></td>
                                <th>Tax</th>
                                <td class="text-right">£ {{number_format($order->tax  / 100, 2)}}</td>
                            </tr>
                            <tr>
                                <td style="border-top: 0" colspan="4"></td>
                                <th>Total</th>
                                <td class="text-right">£ {{$order->total_formatted}}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
