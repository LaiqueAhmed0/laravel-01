<!-- begin:: Subheader -->
<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-subheader__main" style="width: 100%;">


    </div>
</div>

<!-- end:: Subheader -->

<!--begin::Subheader-->
<div class="subheader py-2 py-lg-12 " id="kt_subheader">
    <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Heading-->
            <div class="d-flex flex-column ">
                <!--begin::Title-->
                @if ($subHeader === 'My Cart')
                    <h2 class="text-dark font-weight-bold my-2 mr-5">
                        {!! !empty($subHeader) ? $subHeader : 'N/A' !!}
                    </h2>

                @elseif(isset($subHeaderType) && $subHeaderType === 'sim')
                    <h2 class="text-dark font-weight-bold my-2 mr-5">
                        {!! !empty($subHeader) ? $subHeader : 'N/A' !!} {{$sim->iccid}}
                        @if ($sim->nickname)
                            <div class="mt-2 text-muted font-size-lg">{{$sim->nickname}}</div>
                        @endif
                    </h2>


                @else
                    <h2 class="text-dark font-weight-bold my-2 mr-5">{!! !empty($subHeader) ? $subHeader : 'N/A' !!}</h2>
            @endif
            <!--end::Title-->
            </div>
            <!--end::Heading-->
        </div>
        <!--end::Info-->
        @if(isset($back))
            <a href="{{$back}}" class="btn btn-primary">Back</a>
        @endif
    </div>
</div>
<!--end::Subheader-->
