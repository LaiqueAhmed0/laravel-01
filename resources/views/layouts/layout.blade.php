<!DOCTYPE html>

<html lang="en">

@include('partials.head')
{{--background-image: url(/media/background.jpg); background-position: center top; background-size: 100% 350px;--}}
<!-- begin::Body -->
<body style=""
      class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading">

@include('partials.mobile-header')

<!--end::Header Mobile-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

            @include('partials.header')

            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            @include('partials.subheader')

            <!--begin::Entry-->
                <div class="d-flex flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container-fluid">
                        <!--begin::Dashboard-->

                        @stack('content')

                    </div>
                </div>

                <!-- end:: Content -->
            </div>
            @include('partials.footer')
        </div>
    </div>
</div>

<!-- end:: Page -->

{{--		@include('partials.quick-panel')--}}

{{--		@include('partials.sticky-toolbar')--}}

@include('partials.scripts')

</body>

<!-- end::Body -->
</html>
