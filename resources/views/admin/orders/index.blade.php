@extends('layouts.layout', ['subHeader' => 'Orders'])

@push('content')

    <div class="d-flex flex-row mb-8">
        <div class="card card-custom mr-6" style="width: 33%">
            <div class="card-body d-flex align-items-center py-0 my-8">
                <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                    <span class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">Total
                        Orders</span>
                    <span class="font-weight-bold text-muted font-size-lg">Your total orders </span>
                </div>
                <div class="symbol symbol-light-success symbol-2by3 mr-3">
                    <span class="symbol-label font-weight-bolder">
                        {{\App\Models\Order::count()}}
                    </span>
                </div>
            </div>
        </div>
        <div class="card card-custom mx-2" style="width: 33%">
            <div class="card-body d-flex align-items-center py-0 my-8">
                <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                    <span class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">Total Subtotal</span>
                    <span class="font-weight-bold text-muted font-size-lg">Total amount of money</span>
                </div>
                <div class="symbol symbol-light-danger symbol-2by3 mr-3">
                    <span class="symbol-label font-weight-bolder">
                        £{{number_format(\App\Models\Order::sum('subtotal') / 100, 2)}}
                    </span>
                </div>
            </div>
        </div>
        <div class="card card-custom ml-6" style="width: 33%">
            <div class="card-body d-flex align-items-center py-0 my-8">
                <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                    <span class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">Total Data</span>
                    <span class="font-weight-bold text-muted font-size-lg">Total amount of data</span>
                </div>
                <div class="symbol symbol-light-primary symbol-2by3 mr-3">
                    <span class="symbol-label font-weight-bolder">
{{--                        £{{number_format(\App\Models\Order::sum('tax')/100, 2)}}--}}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom">
        <div class="card-header py-5 border-bottom-0">
            <div class="card-label">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Orders Table</span>
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">All orders on the system</span>
                </h3>
            </div>
            <div class="card-toolbar">
                <div>
                    <label class="font-weight-bolder">From</label>
                    <div class="input-icon">
                        <input id="from" type="date" class="form-control w-200px mr-2" placeholder="From">
                        <span>
                        <i class="flaticon2-calendar-1 icon-md"></i>
                    </span>
                    </div>
                </div>
                <div>
                    <label class="font-weight-bolder">To</label>
                    <div class="input-icon">
                        <input id="to" type="date" class="form-control w-200px mr-2" placeholder="To">
                        <span>
                        <i class="flaticon2-calendar-1 icon-md"></i>
                    </span>
                    </div>
                </div>
                <div>
                    <label class="font-weight-bolder">Search</label>
                    <div class="input-icon">
                        <input id="generalSearch" type="text" class="form-control w-200px mr-2" placeholder="Search...">
                        <span>
                        <i class="flaticon2-search-1 icon-md"></i>
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body ">
            <!--begin: Datatable-->
            <div id="orders"></div>
            <!--end: Datatable-->
        </div>
    </div>
@endpush

@push('scripts')
    {{--    <script src="/js/core.datatable.js" type="text/javascript"></script>--}}
    <script>
        var t = $("#orders").KTDatatable({
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
            search: {
                input: $("#generalSearch")
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
                field: "full_name",
                title: "Name",
            }, {
                field: "company_name",
                title: "Company Name",
            }, {
                field: "plan_name",
                title: "Plan"
            }, {
                field: "plan_length",
                title: "Plan Length"
            }, {
                field: "total_formatted",
                title: "Total",
                template: function (t) {
                    return '£ ' + (t.total_formatted)
                }
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
                        'refund': {
                            title: "Refunded",
                            class: "label-light-danger"
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
                    return '<a class="btn btn-sm btn-clean btn-icon btn-icon-sm" href="/admin/orders/' + t.id + '"><i class="la la-eye"></i> </a>'
                }
            }]
        });

        $('#from').change(function () {
            t.search($(this).val().toLowerCase(), 'from');
        })

        $('#to').change(function () {
            t.search($(this).val().toLowerCase(), 'to');
        })

    </script>
@endpush