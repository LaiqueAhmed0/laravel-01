@extends('layouts.layout')

@push('content')

    <style>
        #simTable table {
            min-height: 307px !important;
        }

        tr.activeRow {
            background-color: #C9F7F5;
        }

        .datatable-row {
            cursor: pointer;
        }
    </style>

    <!--Begin::App-->
    <div class="d-flex flex-row align-content-stretch">

    @include('user.partials.aside')

    <!--Begin:: App Content-->
        <div class="d-flex flex-row-fluid ml-lg-8">
            <div class="card card-custom w-100">
                <div class="card-header border-bottom-0 d-flex align-items-center">
                    <div class="card-label">
                        <h3 class="card-title">
                            Sims
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    <div id="endpoints_datatable" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <!--End:: App Content-->

    <!--End::App-->
@endpush


@push('scripts')

    <script>
        var dataTable = $("#endpoints_datatable").KTDatatable({
            data: {
                type: "remote",
                source: {
                    read: {
                        url: "/admin/users/endpoints/table",
                        params: {
                            '_token': '{{csrf_token()}}',
                            'id': {{$user->id}}
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
                'field': 'id',
                'title': '#',
                'sortable': 'asc',
                'width': 30,
                'textAlign': 'center'
            }, {
                'field': 'iccid',
                'title': 'Iccid',
                'width': 160,
            }, {
                field: 'status',
                title: 'Status'
            },
                {
                    field: "total_usage",
                    title: "Usage",
                    sortable: false,
                    template: function (row) {
                        return row.volume + ' MB';
                    }
                }, {
                    field: "remaining_usage",
                    title: "Remaining Usage",
                    sortable: false,
                    template: function (row) {
                        return row.volume_remaining + ' MB';
                    }
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
                                    <li class="navi-item"><a class="navi-link" href="/dashboard/` + row.iccid + `"> <span class="navi-text">View</span> </a></li>\
                                </ul>\
                            </div>\
                        </div>\
                    `;
                    }
                }]
        });
    </script>
@endpush