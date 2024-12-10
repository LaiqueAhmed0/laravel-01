@extends('layouts.layout')

@push('content')

    <div class="card card-custom">
        <div class="card-header py-5 border-bottom-0">
            <div class="card-label">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Retailers Table</span>
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">All retailers on the system</span>
                </h3>
            </div>
            <div class="card-toolbar">
                <div class="input-icon">
                    <input id="generalSearch" type="text" class="form-control w-200px mr-2" placeholder="Search...">
                    <span>
                        <i class="flaticon2-search-1 icon-md"></i>
                    </span>
                </div>
                <a href="/admin/retailers/create" class="btn btn-info font-weight-bolder font-size-sm mr-3">
                    <i class="la la-plus"></i>
                    New Retailer
                </a>
            </div>
        </div>

        <div class="card-body ">
            <!--begin: Datatable-->
            <div class="kt-datatable" style="">

            </div>
            <!--end: Datatable-->
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
                                url: "/admin/retailers/table",
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
                    search: {
                        input: $("#generalSearch")
                    },
                    columns: [{
                        field: "id",
                        title: "#",
                        sortable: "asc",
                        width: 30,
                        type: "number",
                        selector: false,
                        textAlign: "center"
                    }, {
                        field: "name",
                        title: "Name"
                    }, {
                        field: "address",
                        title: "Address"
                    }, {
                        field: "postcode",
                        title: "Postcode"
                    }, {
                        field: "total_sims",
                        title: "Sims"
                    }, {
                        field: "total_claimed",
                        title: "Sims Claimed"
                    }, {
                        field: "Actions",
                        title: "Actions",
                        sortable: !1,
                        width: 110,
                        overflow: "visible",
                        autoHide: !1,
                        template: function (t) {
                            return '<a class="btn btn-sm btn-clean btn-icon btn-icon-sm" href="/admin/retailers/view/' + t.id + '"><i class="la la-eye"></i> </a>'
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