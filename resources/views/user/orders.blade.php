@extends('layouts.layout')

@push('content')
    <div class="d-flex flex-row">
{{--        @include('user.partials.aside')--}}
        <div class="flex-row-fluid ml-lg-12">
            <div class="card card-custom card-stretch">
                <div class="card-header py-3">
                    <div class="card-title align-items-start flex-column">
                        <h3 class="card-label font-weight-bolder text-dark">My Orders</h3>
                        <span class="text-muted font-weight-bold font-size-sm mt-1">view my previous orders</span>
                    </div>
                </div>
                <div class="card-body">
                    <div id="orders"></div>
                </div>
            </div>

        </div>
    </div>
@endpush

@push('scripts')
    <script>
        "use strict";
        var KTDatatableRemoteAjaxDemo = {
            init: function () {
                var t;
                t = $("#orders").KTDatatable({
                    data: {
                        type: "remote",
                        source: {
                            read: {
                                url: "/orders/table",
                                params: {
                                    _token: '{{csrf_token()}}'
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
                    sortable: !0,
                    pagination: !0,
                    columns: [{
                        field: "id",
                        title: "Order ID",
                        width: 100,
                        type: "number",
                        selector: !1,
                        template: function (t) {
                            return 1000000000 + t.id;
                        }
                    }, {
                        field: "total_formatted",
                        title: "Total",
                        template: function (t) {
                            return '£ ' + (t.total_formatted)
                        }
                    }, {
                        field: "plan_name",
                        title: "Plan"
                    }, {
                        field: "plan_length",
                        title: "Plan Length"
                    }, {
                        field: "created_at_formatted",
                        title: "Date"
                    }, {
                        field: "status",
                        title: "Status",
                        template: function (t) {
                            var e = {
                                'pending': {
                                    title: "Pending Payment",
                                    class: "label-light-primary"
                                },
                                'processing': {
                                    title: "Processing",
                                    class: "label-light-success"
                                },
                                'completed': {
                                    title: "Completed",
                                    class: "label-light-success"
                                },
                                'failed': {
                                    title: "Cancelled",
                                    class: "label-light-danger"
                                },
                                'cancelled': {
                                    title: "Cancelled",
                                    class: "label-light-danger"
                                }
                            };

                            return '<span class="label label-lg ' + e[t.status].class + ' label-inline">' + e[t.status].title + "</span>"
                        }
                    }, {
                        field: "Actions",
                        title: "Actions",
                        sortable: !1,
                        width: 110,
                        overflow: "visible",
                        autoHide: !1,
                        template: function (t) {
                            return '<a class="btn btn-sm btn-clean btn-icon btn-icon-sm" href="/profile/orders/' + t.id + '"><i class="la la-eye"></i> </a>'
                        }
                    }]
                });
            }
        };
        jQuery(document).ready(function () {
            KTDatatableRemoteAjaxDemo.init()
        });
    </script>
@endpush
