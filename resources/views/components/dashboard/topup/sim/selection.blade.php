<!--begin::Base Table Widget 1-->
<div class="card card-custom gutter-b">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">Your Sim Cards</span>
            <span class="text-muted mt-3 font-weight-bold font-size-sm">Here are your registered sim cards. Click the arrow to view more info.</span>
        </h3>
        <div class="card-toolbar">
            <a href="/dashboard/{{$endpoint->iccid}}" class="btn btn-sm btn-success font-weight-bold">View Usage</a>
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body pt-2 pb-0 mt-n3">
        <!--begin::Table-->
        <div class="table-responsive">
            <table class="table table-borderless table-vertical-center">
                <thead>
                <tr>
                    <th class="p-0"></th>
                    <th class="p-0 min-w-120px"></th>
                    <th class="p-0 min-w-120px"></th>
                    <th class="p-0 min-w-120px"></th>
                    <th class="p-0 min-w-120px"></th>
                </tr>
                </thead>
                <tbody>
                @if ($endpoints)
                    @foreach($endpoints as $item)
                        <x-dashboard.topup.sim.item :item="$item" :endpoint="$endpoint"></x-dashboard.topup.sim.item>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <!--end::Table-->
    </div>
</div>
<!--end::Base Table Widget 1-->
