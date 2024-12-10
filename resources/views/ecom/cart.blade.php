@extends('layouts.layout')


@push('content')
    <div class="row">
        <div class="col-lg-9">
            <div class="card card-custom card-stretch">
                <div class="card-body">
                    <div id="cart-table">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-custom card-stretch">
                <div class="card-header py-3">
                    <div class="card-title align-items-start flex-column">
                        <h3 class="card-label font-weight-bolder text-dark">
                            Basket Totals
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table" style="font-size: 16px;">
                        <tr>
                            <th>Total</th>
                            <td>£ {{$subtotal}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a style="width: 100%; margin-top: 20px" href="/checkout" class="btn btn-sm btn-success font-weight-bold">Proceed
                                    to checkout</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endpush

@push('scripts')

    <script>
        var cartTable = {
            init: function () {
                var t;
                t = $("#cart-table").KTDatatable({
                    data: {
                        type: "remote",
                        source: {
                            read: {
                                url: "/cart/table",
                                params: {
                                    '_token': '{{csrf_token()}}'
                                },
                                map: function (t) {
                                    var e = t;
                                    return void 0 !== t.data && (e = t.data), e
                                }
                            }
                        },
                        pageSize: 10,
                        serverPaging: !0,
                        serverFiltering: !0,
                        serverSorting: !0
                    },
                    layout: {
                        scroll: !1,
                        footer: !1
                    },
                    sortable: !1,
                    pagination: !1,
                    columns: [{
                        field: "plan",
                        title: "Data Plan",
                    }, {
                        field: "iccid",
                        title: "Sim ID",
                        width: 160
                    },{
                        field: "scheduled",
                        title: "Scheduled",
                        width: 100,
                    }, {
                        field: 'rate',
                        title: 'Price',
                        width: 100,
                    }, {
                        field: 'quantity',
                        title: 'Qty',
                        width: 50,
                    }, {
                        field: 'total',
                        title: 'Total',
                        width: 100,
                    }, {
                        field: '',
                        title: '',
                        width: 50,
                        template: function (t) {
                            return '<a  class="btn btn-sm btn-clean btn-icon btn-icon-sm" href="/cart/remove/' + t.id + '"><i style="color: red" class="la la-close"></i> </a>'
                        }
                    }]
                })
            }
        };
        jQuery(document).ready(function () {
            cartTable.init();
        });
    </script>

@endpush
