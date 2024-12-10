
    <!--begin::Base Table Widget 1-->
    <div class="card card-custom gutter-b">
        <!--begin::Header-->
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">Your Sim Cards</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">Here are your registered sim cards. Click the arrow to view more info.</span>
            </h3>
            <div class="card-toolbar">
                <a href="/sim/register" class="btn btn-sm btn-success font-weight-bold">Register New Sim</a>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body pt-2 pb-0 mt-n3">

        </div>
    </div>
    <!--end::Base Table Widget 1-->


    @if ($sims)
        <div style="">


            @foreach($sims as $item)
                <x-dashboard.sim.item :item="$item"></x-dashboard.sim.item>
            @endforeach
        </div>
    @endif


<style>
    .nickname {
        cursor: pointer;
    }

    .bm-popover {
        width: 220px;
        position: absolute;
        box-shadow: 3px 4px 6px 1px #00000091;
        border-radius: 4px;
        top: 41px;
        left: 0px;
    }
</style>

@push('scripts')

    <script>
        function removeUserSimAreYouSure(iccid) {
            Swal.fire({
                title: "Are you sure you want to remove the sim?",
                text: "",
                icon: "warning",
                showCancelButton: true,
                dangerMode: true,
            }).then((willDelete) => {
                // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
                if (willDelete.isConfirmed) {
                    window.location.href = "/sim/remove/" + iccid
                } else {

                }
            });
        }
    </script>

    <script>
        $('.nickname').each(function () {
            $(this).click(function () {
                $(this).siblings('.bm-popover').fadeIn(200);
            });
        })

        $('.nickname-close').each(function () {
            $(this).click(function () {
                console.log('test');
                $(this).parent().parent().parent().fadeOut(200);
            });
        })
    </script>

@endpush
