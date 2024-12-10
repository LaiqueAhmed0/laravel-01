@extends('layouts.layout')

@push('content')

    <style>
        #simTable table {
            min-height: 307px !important;
        }

        tr.activeRow {
            background-color: rgba(0, 78, 255, 0.3);
        }

        .kt-datatable__row {
            cursor: pointer;
        }
    </style>

    <!--Begin::App-->
    <div class="d-flex flex-row">
    @include('retailer.partials.aside')
    <!--Begin:: App Content-->
        <div class="flex-row-fluid ml-lg-8 d-flex flex-row flex-wrap">
            <div class="card card-custom mr-4 mb-8" style="width: calc(50% - 1rem )">
                <div class="card-body d-flex align-items-center py-0 my-8">
                    <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">Total Sim Cards</a>
                        <span class="font-weight-bold text-muted font-size-lg">Your total sim cards </span>
                    </div>
                    <div class="symbol symbol-light-success symbol-2by3 mr-3">
                    <span class="symbol-label font-weight-bolder">
                        {{$retailer->total_sims}}
                    </span>
                    </div>
                </div>
            </div>
            <div class="card card-custom ml-4 mb-8" style="width: calc(50% - 1rem )">
                <div class="card-body d-flex align-items-center py-0 my-8">
                    <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">Total Unassigned</a>
                        <span class="font-weight-bold text-muted font-size-lg">Total unassigned sims</span>
                    </div>
                    <div class="symbol symbol-light-danger symbol-2by3 mr-3">
                    <span class="symbol-label font-weight-bolder">
                        {{$retailer->total_unclaimed}}
                    </span>
                    </div>
                </div>
            </div>
            <div class="card card-custom mr-4" style="width: calc(50% - 1rem )">
                <div class="card-body d-flex align-items-center py-0 my-8">
                    <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">Total Usage</a>
                        <span class="font-weight-bold text-muted font-size-lg">Total combined usage</span>
                    </div>
                    <div class="symbol symbol-light-primary symbol-2by3 mr-3">
                        <span class="symbol-label font-weight-bolder">
                             {{number_format($retailer->total_combined_usage, 2)}} GB
                        </span>
                    </div>
                </div>
            </div>
            <div class="card card-custom ml-4" style="width: calc(50% - 1rem )">
                <div class="card-body d-flex align-items-center py-0 my-8">
                    <div class="d-flex flex-column flex-grow-1 py-2 py-lg-5">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h5 mb-2 text-hover-primary">Remaining Usage</a>
                        <span class="font-weight-bold text-muted font-size-lg">Total usage remaining</span>
                    </div>
                    <div class="symbol symbol-light-info symbol-2by3 mr-3">
                    <span class="symbol-label font-weight-bolder">
                         {{number_format($retailer->total_combined_usage_remaining, 2)}} GB
                    </span>
                    </div>
                </div>
            </div>
        </div>
        <!--End:: App Content-->
    </div>

    <div class="mt-8">
        <div class="card card-custom">
            <div class="card-header border-bottom-0 d-flex align-items-center">
                <div class="card-label">
                    <h3 class="card-title">
                        Sims
                    </h3>
                </div>
                <div class="card-toolbar">
                    <a href="/admin/retailers/{{$retailer->id}}/import" class="btn btn-info font-weight-bolder">
                        <i class="fa fa-upload icon-1x"></i>
                        Assign Sims
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="endpoints_datatable" style="width: 100%"></div>
            </div>
        </div>
    </div>

    <!--End::App-->
@endpush

@push('scripts')

    <script>
        var dataTable = $("#endpoints_datatable").KTDatatable({
            data: {
                type: "remote",
                source: {
                    read: {
                        url: "/admin/retailers/endpoints/table",
                        params: {
                            '_token': '{{csrf_token()}}',
                            'id': {{$retailer->id}}
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
                scroll: 1,
                footer: !1
            },
            sortable: !0,
            pagination: !0,
            search: {
                input: $("#generalSearch")
            },
            rows: {
                beforeTemplate: function (row, data, index) {
                    if (data.reconciled !== undefined) {
                        row.css('background-color', !!data.reconciled ? '#d7e9c7' : '#fad6d6');
                    }
                },
                autoHide: !1
            },
            columns: [{
                field: "serial_no",
                title: "Serial No",
                width: 150
            }, {
                field: "iccid",
                title: "ICCID",
                width: 160
            }, {
                field: "current_plan_name",
                title: "Current Plan",
                width: 240,
            }, {
                field: "claimed_by",
                title: "Claimed By",
                width: 240,
            }, {
                    field: 'actions',
                    title: 'Actions',
                    width: 80,
                    template: function (row) {
                        return `<div class="dropdown dropdown-inline">\
                            <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" data-toggle="dropdown">\
                                <span class="svg-icon svg-icon-md">\
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                            <rect x="0" y="0" width="24" height="24"></rect>\
                                            <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"></path>\
                                        </g>\
                                    </svg>\
                                </span>\
                            </a>\
                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">\
                                <ul class="navi flex-column navi-hover py-2">\
                                    <li class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2">Choose an action:</li>\
                                    ` + (!row.claimed_by ? `<li class="navi-item"><a class="navi-link" href="#"><span class="navi-text">Send Endpoint</span> </a></li>` : ``) + `\
                                    <li class="navi-item"><a class="navi-link" href="/dashboard/` + row.iccid + `"> <span class="navi-text">View</span> </a></li>\

                                </ul>\
                            </div>\
                        </div>\
                    `;
                    }
                }]

                // <li class="navi-item"><a class="navi-link" href="#"> <span class="navi-text">Top-up</span> </a></li>\
        });
    </script>
@endpush