@extends('layouts.layout')

@push('content')

    <div class="flex-row-fluid">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-body p-0">
                <!-- begin: Invoice-->
                <!-- begin: Invoice header-->
                <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                    <div class="col-md-10">
                        <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                            <h1 class="display-4 font-weight-boldest mb-10 text-uppercase">Thanks for your order<br><span class="font-size-h6 text-muted">See order details below</span></h1>
                            <div class="d-flex flex-column align-items-md-end px-0">
                                  <!--begin::Logo-->
                                <a href="#" class="mb-5">
                                    <img src="/media/lmd.svg" alt="" height="50">
                                </a>
                                <!--end::Logo-->
                                <span class="d-flex flex-column align-items-md-end opacity-70">
                                    <span>27 Old Gloucester Street,</span>
                                    <span>London, United Kingdom, WC1N 3AX</span>
                                </span>
                            </div>
                        </div>
                        <div class="border-bottom w-100"></div>
                        <div class="d-flex justify-content-between pt-6">
                            <div class="d-flex flex-column flex-root">
                                <span class="font-weight-bolder mb-2">ORDER DATE</span>

                                <span class="opacity-70">{{$order->created_at->format('M d, Y')}}</span>
                            </div>
                            <div class="d-flex flex-column flex-root">
                                <span class="font-weight-bolder mb-2">ORDER NO.</span>
                                <span class="opacity-70">{{$order->id_formatted}}</span>
                            </div>
                            <div class="d-flex flex-column flex-root">
                                <span class="font-weight-bolder mb-2">DELIVERED TO.</span>
                                <span class="opacity-70">{{$order->first_name}} {{$order->last_name}}, {{$order->address_1}}{{$order->address_2 ? ', ' . $order->address_2 : ''}}<br>
                                    {{$order->city}}{{$order->county ? ', ' . $order->county : ''}}, {{$order->postcode}}, {{$order->country}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice header-->
                <!-- begin: Invoice body-->
                <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="pl-0 font-weight-bold text-muted text-uppercase">Ordered Items</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase">Qty</th>
                                    <th class="text-right font-weight-bold text-muted text-uppercase">Unit Price</th>
                                    <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr class="font-weight-boldest">
                                        <td class="border-0 pl-0 pt-7 d-flex align-items-center">
                                            <!--begin::Symbol-->
{{--                                            <div class="symbol symbol-40 flex-shrink-0 mr-4 bg-light">--}}
{{--                                                <div class="symbol-label" style="background-image: url('{{$item->image}}')"></div>--}}
{{--                                            </div>--}}
                                            <!--end::Symbol-->
                                            <div class="d-flex flex-column">
                                                <span>
                                                    {{$item->plan->name}} - {{$item->plan->length}} Days
                                                </span>
                                                <span class="text-muted font-weight-normal">
                                                    {{$item->sim->iccid}}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-right pt-7 align-middle">{{$item->quantity}}</td>
                                        <td class="text-right pt-7 align-middle">£ {{number_format($item->price / 100, 2)}}</td>
                                        <td class="text-primary pr-0 pt-7 text-right align-middle">£ {{number_format(($item->price * $item->quantity) / 100, 2)}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice body-->
                <!-- begin: Invoice footer-->
                <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0 mx-0">
                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="font-weight-bold text-muted text-uppercase">PAYMENT TYPE</th>
                                    <th class="font-weight-bold text-muted text-uppercase">PAYMENT STATUS</th>
                                    <th class="font-weight-bold text-muted text-uppercase">PAYMENT DATE</th>
                                    <th class="font-weight-bold text-muted text-uppercase text-right">SUBTOTAL</th>
                                    <th class="font-weight-bold text-muted text-uppercase text-right">TAX</th>
                                    <th class="font-weight-bold text-muted text-uppercase text-right">TOTAL PAID</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="font-weight-bolder">
                                    <td>Credit Card</td>
                                    <td>Success</td>
                                    <td>{{$order->updated_at->format('M d, Y')}}</td>
                                    <td class="text-primary font-size-h3 font-weight-boldest text-right">£ {{number_format($order->subtotal / 100, 2)}}</td>
                                    <td class="text-primary font-size-h3 font-weight-boldest text-right">£ {{number_format($order->tax / 100, 2)}}</td>
                                    <td class="text-primary font-size-h3 font-weight-boldest text-right">£ {{number_format($order->total / 100, 2)}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice footer-->
                <!-- begin: Invoice action-->
                <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                    <div class="col-md-10">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-light-primary font-weight-bold" onclick="window.print();">Download Invoice Details</button>
                        </div>
                    </div>
                </div>
                <!-- end: Invoice action-->
                <!-- end: Invoice-->
            </div>
        </div>
        <!--end::Card-->
    </div>

@endpush
