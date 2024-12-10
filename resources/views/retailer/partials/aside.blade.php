<!--begin::Aside-->
<div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
    <!--begin::Profile Card-->
    <div class="card card-custom card-stretch">
        <!--begin::Body-->
        <div class="card-body pt-8">

            <!--begin::User-->
            <div class="d-flex align-items-center">
                <div class="symbol symbol-light-success symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                    <span class="symbol-label font-size-h2 font-weight-bold">{{substr ($retailer->name, 0, 1)}}</span>
                    <i class="symbol-badge bg-success"></i>
                </div>
                <div>
                    <a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{$retailer->name}}</a>
                    <div class="text-muted">{{'Retailer'}}</div>
                </div>
            </div>
            <!--end::User-->
            <!--begin::Contact-->
            <div class="py-9">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="font-weight-bold mr-2">Address:</span>
                    <span  class="text-muted">{{$retailer->address}}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="font-weight-bold mr-2">Postcode:</span>
                    <span class="text-muted">{{$retailer->postcode}}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="font-weight-bold mr-2">Country:</span>
                    <span class="text-muted">{{$retailer->country == 'null' ? '' : $retailer->country_name}}</span>
                </div>
            </div>
            <!--end::Contact-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Profile Card-->
</div>
<!--end::Aside-->


