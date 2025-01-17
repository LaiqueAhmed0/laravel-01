<!DOCTYPE html>

<html lang="en">

@include('partials.head')

<!-- begin::Body -->
<body style="background-image: url(/media/demos/demo4/header.jpg); background-position: center top; background-size: 100% 350px;" class="kt-page--loading-enabled kt-page--loading kt-page--fixed kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-menu kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">
<!-- begin::Page loader -->
<!-- end::Page Loader -->
<!-- begin:: Page -->
{{--@include('partials.mobile-header')--}}

<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

            @include('partials.header')


            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-grid--stretch">
                <div class="kt-container kt-body  kt-grid kt-grid--ver" id="kt_body">
                    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

                    @include('partials.subheader')

                    <!-- begin:: Content -->
                        <div class="kt-content kt-grid__item kt-grid__item--fluid">

                            @yield('content')

                        </div>

                        <!-- end:: Content -->
                    </div>
                </div>
            </div>

{{--            @include('partials.footer')--}}

        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#366cf3",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin:: Global Mandatory Vendors -->
<script src="/vendors/general/jquery/dist/jquery.js" type="text/javascript"></script>
<script src="/vendors/general/popper.js/dist/umd/popper.js" type="text/javascript"></script>
<script src="/vendors/general/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/vendors/general/js-cookie/src/js.cookie.js" type="text/javascript"></script>
<script src="/vendors/general/moment/min/moment.min.js" type="text/javascript"></script>
<script src="/vendors/general/tooltip.js/dist/umd/tooltip.min.js" type="text/javascript"></script>
<script src="/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js" type="text/javascript"></script>
<script src="/vendors/general/sticky-js/dist/sticky.min.js" type="text/javascript"></script>
<script src="/vendors/general/wnumb/wNumb.js" type="text/javascript"></script>

<!--end:: Global Mandatory Vendors -->

<!--begin:: Global Optional Vendors -->
<script src="/vendors/general/jquery-form/dist/jquery.form.min.js" type="text/javascript"></script>
<script src="/vendors/general/block-ui/jquery.blockUI.js" type="text/javascript"></script>
<script src="/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="/vendors/custom/js/vendors/bootstrap-datepicker.init.js" type="text/javascript"></script>
<script src="/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="/vendors/custom/js/vendors/bootstrap-timepicker.init.js" type="text/javascript"></script>
<script src="/vendors/general/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script>
<script src="/vendors/general/bootstrap-maxlength/src/bootstrap-maxlength.js" type="text/javascript"></script>
<script src="/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js" type="text/javascript"></script>
<script src="/vendors/general/bootstrap-select/dist/js/bootstrap-select.js" type="text/javascript"></script>
<script src="/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js" type="text/javascript"></script>
<script src="/vendors/custom/js/vendors/bootstrap-switch.init.js" type="text/javascript"></script>
<script src="/vendors/general/select2/dist/js/select2.full.js" type="text/javascript"></script>
<script src="/vendors/general/ion-rangeslider/js/ion.rangeSlider.js" type="text/javascript"></script>
<script src="/vendors/general/typeahead.js/dist/typeahead.bundle.js" type="text/javascript"></script>
<script src="/vendors/general/handlebars/dist/handlebars.js" type="text/javascript"></script>
<script src="/vendors/general/inputmask/dist/jquery.inputmask.bundle.js" type="text/javascript"></script>
<script src="/vendors/general/inputmask/dist/inputmask/inputmask.date.extensions.js" type="text/javascript"></script>
<script src="/vendors/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js" type="text/javascript"></script>
<script src="/vendors/general/nouislider/distribute/nouislider.js" type="text/javascript"></script>
<script src="/vendors/general/owl.carousel/dist/owl.carousel.js" type="text/javascript"></script>
<script src="/vendors/general/autosize/dist/autosize.js" type="text/javascript"></script>
<script src="/vendors/general/clipboard/dist/clipboard.min.js" type="text/javascript"></script>
<script src="/vendors/general/dropzone/dist/dropzone.js" type="text/javascript"></script>
<script src="/vendors/general/summernote/dist/summernote.js" type="text/javascript"></script>
<script src="/vendors/general/markdown/lib/markdown.js" type="text/javascript"></script>
<script src="/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
<script src="/vendors/custom/js/vendors/bootstrap-markdown.init.js" type="text/javascript"></script>
<script src="/vendors/general/bootstrap-notify/bootstrap-notify.min.js" type="text/javascript"></script>
<script src="/vendors/custom/js/vendors/bootstrap-notify.init.js" type="text/javascript"></script>
<script src="/vendors/general/jquery-validation/dist/jquery.validate.js" type="text/javascript"></script>
<script src="/vendors/general/jquery-validation/dist/additional-methods.js" type="text/javascript"></script>
<script src="/vendors/custom/js/vendors/jquery-validation.init.js" type="text/javascript"></script>
<script src="/vendors/general/toastr/build/toastr.min.js" type="text/javascript"></script>
<script src="/vendors/general/raphael/raphael.js" type="text/javascript"></script>
<script src="/vendors/general/morris.js/morris.js" type="text/javascript"></script>
<script src="/vendors/general/chart.js/dist/Chart.bundle.js" type="text/javascript"></script>
<script src="/vendors/custom/vendors/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js" type="text/javascript"></script>
<script src="/vendors/custom/vendors/jquery-idletimer/idle-timer.min.js" type="text/javascript"></script>
<script src="/vendors/general/waypoints/lib/jquery.waypoints.js" type="text/javascript"></script>
<script src="/vendors/general/counterup/jquery.counterup.js" type="text/javascript"></script>
<script src="/vendors/general/es6-promise-polyfill/promise.min.js" type="text/javascript"></script>
<script src="/vendors/general/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script>
<script src="/vendors/custom/js/vendors/sweetalert2.init.js" type="text/javascript"></script>
<script src="/vendors/general/jquery.repeater/src/lib.js" type="text/javascript"></script>
<script src="/vendors/general/jquery.repeater/src/jquery.input.js" type="text/javascript"></script>
<script src="/vendors/general/jquery.repeater/src/repeater.js" type="text/javascript"></script>
<script src="/vendors/general/dompurify/dist/purify.js" type="text/javascript"></script>

<!--end:: Global Optional Vendors -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="/js/scripts.bundle.js" type="text/javascript"></script>

<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->
<script src="/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
<script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
<script src="/vendors/custom/gmaps/gmaps.js" type="text/javascript"></script>

<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
<script src="/js/pages/dashboard.js" type="text/javascript"></script>

@yield('endScripts')

<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>
