@extends('layouts.layout')

@push('content')

    <div class="card card-custom">
        <div class="card-header py-5 border-bottom-0">
            <div class="card-label">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Sims Table</span>
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">All sims on the system</span>
                </h3>
            </div>
            <div class="card-toolbar">
                <a href="/admin/endpoints/export" class="btn btn-success ml-3 mr-5">Export</a>
                <div class="input-icon">
                    <input id="generalSearch" type="text" class="form-control w-200px mr-2" placeholder="Search...">
                    <span>
                        <i class="flaticon2-search-1 icon-md"></i>
                    </span>
                </div>
                <a href="/admin/endpoints/create" class="btn btn-success ml-3 mr-5">Activate Sims</a>
                <a href="/admin/endpoints/delete" class="btn btn-danger">Deactivate Sims</a>
            </div>
        </div>

        <div class="card-body ">
            <!--begin: Datatable -->
            <div class="kt-datatable" style="">

            </div>
            <!--end: Datatable -->
        </div>
    </div>
@endpush

@push('scripts')
    {{--    <script src="/js/core.datatable.js" type="text/javascript"></script>--}}
    <script>
        "use strict";
        var KTDatatableRemoteAjaxDemo = {
            init: function () {
                var t;
                t = $(".kt-datatable").KTDatatable({
                    data: {
                        type: "remote",
                        source: {
                            read: {
                                url: "/admin/sims/table",
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
                    sortable: 0,
                    pagination: !0,
                    search: {
                        input: $("#generalSearch")
                    },
                    columns: [{
                        field: "id",
                        title: "#",
                        sortable: "asc",
                        width: 30,
                        type: "number",
                        selector: !1,
                        textAlign: "center"
                    }, {
                        field: "serial_no",
                        title: "Serial No",
                        width: 150
                    }, {
                        field: "iccid",
                        title: "ICCID",
                        width: 160
                    }, {
                        field: "retailer_name",
                        title: "Retailer"
                    }, {
                        field: "current_plan_name",
                        title: "Current Plan"
                    }, {
                        field: "claimed_by",
                        title: "Claimed By"
                    }, {
                        field: "Actions",
                        title: "Actions",
                        sortable: !1,
                        width: 110,
                        overflow: "visible",
                        autoHide: !1,
                        template: function (t) {
                            return '<a class="btn btn-sm btn-clean btn-icon btn-icon-sm" href="/dashboard/' + t.iccid + '"><i class="la la-eye"></i> </a><a class="btn btn-sm btn-clean btn-icon btn-icon-sm" href="/admin/sims/add-plan/' + t.id + '"><i class="la la-pen"></i> </a>'
                        }
                    }]
                }), $("#kt_form_status").on("change", function () {
                    t.search($(this).val().toLowerCase(), "Status")
                }), $("#kt_form_type").on("change", function () {
                    t.search($(this).val().toLowerCase(), "Type")
                }), $("#kt_form_status,#kt_form_type").selectpicker()
            }
        };
        jQuery(document).ready(function () {
            KTDatatableRemoteAjaxDemo.init()
        });
    </script>
@endpush