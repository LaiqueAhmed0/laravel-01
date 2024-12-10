@extends('layouts.layout')

@push('content')


    <div class="card mb-5">
        <div class="card-header border-bottom-0 pb-0">
            <div class="card-label">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Catalog Settings</span>
                </h3>
            </div>
        </div>
        <div class="card-body d-flex" style="gap: 20px">
            <div class="w-300px">
                <form method="post" action="/admin/plans/set-markup">
                    @csrf
                    <label>Markup (percentage)</label>
                    <input name="markup" class="form-control mb-5" value="{{\App\Models\Setting::where('name', 'markup')->first()->value ?? null}}">
                    <button type="submit" class="btn btn-success">Set Markup</button>
                </form>
            </div>
            <div class="w-300px">
                <form method="post" action="/admin/plans/set-conversion">
                    @csrf
                    <label>Conversion Rate (EUR to GBP)</label>
                    <input name="rate" class="form-control mb-5" value="{{\App\Models\Setting::where('name', 'conversion')->first()->value ?? null}}">
                    <button type="submit" class="btn btn-success">Set Rate</button>
                </form>
            </div>

        </div>
    </div>
    <div class="card card-custom">
        <div class="card-header py-5 border-bottom-0">
            <div class="card-label">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Plans Table</span>
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">All plans on the system</span>
                </h3>
            </div>
            <div class="card-toolbar">
                <div class="input-icon">
                    <input id="generalSearch" type="text" class="form-control w-200px mr-2" placeholder="Search...">
                    <span>
                        <i class="flaticon2-search-1 icon-md"></i>
                    </span>
                </div>
                <a href="/admin/plans/create" class="btn btn-info font-weight-bolder font-size-sm mr-3">
                    <i class="la la-plus"></i>
                    New Plan
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
                                url: "/admin/plans/table",
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
                        selector: !1,
                        textAlign: "center"
                    }, {
                        field: "name",
                        title: "Name"
                    }, {
                        field: "credit",
                        title: "Allowance",
                        template: function (r) {
                            return (r['credit'] / 1000) + 'GB'
                        }
                    }, {
                        field: "pricing",
                        title: "Price",
                        template: function (r) {
                            return '£' + (r['pricing'] / 100).toFixed(2);
                        }
                    },{
                        field: "length",
                        title: "Validity",
                        template: function (r) {
                            return r['length'] + ' Days';
                        }
                    }, {
                        field: "Actions",
                        title: "Actions",
                        sortable: !1,
                        width: 110,
                        overflow: "visible",
                        autoHide: !1,
                        template: function (t) {
                            return '<a class="btn btn-sm btn-clean btn-icon btn-icon-sm" href="/admin/plans/edit/' + t.id + '"><i class="la la-pen"></i> </a><a class="btn btn-sm btn-clean btn-icon btn-icon-sm" href="/admin/plans/copy/' + t.id + '"><i class="la la-copy"></i> </a>'
                        }
                    }]
                }), $("#kt_form_status").on("change", function () {
                    t.search($(this).val().toLowerCase(), "Status")
                }), $("#kt_form_type").on("change", function () {
                    t.search($(this).val().toLowerCase(), "Type")
                }), $("#kt_form_status,#kt_form_type").selectpicker(),
                    t.on('draw', function () {
                        console.log('test');
                    })
            }
        };
        jQuery(document).ready(function () {
            KTDatatableRemoteAjaxDemo.init()
        });
    </script>
@endpush