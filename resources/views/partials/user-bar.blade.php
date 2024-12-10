<!--begin::User-->
<div class="dropdown">
    <!--begin::Toggle-->
    <div class="topbar-item">
        <div class=" btn-icon btn-hover-transparent-white d-flex align-items-center btn-lg px-md-2 w-md-auto mr-1"
             id="kt_quick_user_toggle">
            <span class="text-white opacity-70 font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
            <span class="text-white opacity-90 font-weight-bolder font-size-base d-none d-md-inline mr-4">{{Auth::user()->first_name}}</span>
            <span class="symbol symbol-35">
                <span class="symbol-label text-white font-size-h5 font-weight-bold bg-white-o-30">{{substr (Auth::user()->first_name, 0, 1)}}</span>
            </span>
        </div>
    </div>
    <!--end::Toggle-->
</div>
<!--end::User-->




