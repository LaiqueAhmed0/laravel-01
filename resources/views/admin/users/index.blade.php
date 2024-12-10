@extends('layouts.layout')

@push('content')

    <div class="card card-custom">
        <div class="card-header py-5 border-bottom-0">
            <div class="card-label">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">User Table</span>
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">All users on the system</span>
                </h3>
            </div>
            <div class="card-toolbar d-flex">
                <a href="/admin/users/export" class="btn btn-info font-weight-bolder font-size-sm mr-3">
                    <i class="la la-plus"></i>
                    Export
                </a>
                <div class="input-icon">
                    <input id="generalSearch" type="text" class="form-control w-200px mr-2" placeholder="Search...">
                    <span>
                        <i class="flaticon2-search-1 icon-md"></i>
                    </span>
                </div>
                <a href="/admin/users/create" class="btn btn-info font-weight-bolder font-size-sm mr-3">
                    <i class="la la-plus"></i>
                    New User
                </a>
            </div>
        </div>

        <div class="card-body pt-0 pb-6">
            <!--begin: Datatable -->
            <div class="kt-datatable" style="">

            </div>
            <!--end: Datatable -->
        </div>
    </div>
@endpush

@push('scripts')
    <script src="/js/core.datatable.js" type="text/javascript"></script>
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
                                url: "/admin/users/table",
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
                        field: "email",
                        title: "Email",
                        width: 250
                    }, {
                        field: "phone",
                        title: "Phone"
                    }, {
                        field: "postcode",
                        title: "Postcode"
                    }, {
                        field: "group",
                        title: "Group",
                        template: function (t) {
                            var e = {
                                1: {
                                    title: "Customer",
                                    class: "kt-badge--primary"
                                },
                                2: {
                                    title: "Retailer",
                                    class: "kt-badge--warning"
                                },
                                3: {
                                    title: "Admin",
                                    class: "kt-badge--success"
                                }
                            };
                            return '<span class="kt-badge ' + e[t.group].class + ' kt-badge--inline kt-badge--pill">' + e[t.group].title + "</span>"
                        }
                    }, {
                        field: "Actions",
                        title: "Actions",
                        sortable: !1,
                        width: 110,
                        overflow: "visible",
                        autoHide: !1,
                        template: function (t) {
                            return '<a class="btn btn-sm btn-clean btn-icon btn-icon-sm" href="/admin/users/' + t.id + '/edit"><i class="la la-pen"></i> </a><button class="btn btn-sm btn-clean btn-icon btn-icon-sm" onclick="areYouSureDeleteUser(' + t.id + ')"><i class="la la-trash"></i> </a>'
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
    <script>
        function areYouSureDeleteUser(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "This will remove the user from the portal.",
                icon: "warning",
                showCancelButton: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    window.location.href = '/admin/users/' + id + '/delete'
                }
            });
        }
    </script>
@endpush