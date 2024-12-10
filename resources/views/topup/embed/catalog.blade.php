<!DOCTYPE html>

<html lang="en">

@include('partials.head')
{{--background-image: url(/media/background.jpg); background-position: center top; background-size: 100% 350px;--}}
<!-- begin::Body -->
<body style="" class="page-loading" style="background: white">


<!--end::Header Mobile-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Entry-->
                <div class="d-flex flex-column-fluid">
                    <!--begin::Container-->

                    <livewire:catalog :embed="true"/>

                </div>

                <!-- end:: Content -->
            </div>
        </div>
    </div>
</div>

@include('partials.scripts')

</body>

<!-- end::Body -->
</html>
