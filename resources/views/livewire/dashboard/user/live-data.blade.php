<div class="row m-0 text-sm-left text-center">
    <div class="col-lg-12 px-8 pb-6">
        <div class="font-size-sm text-muted font-weight-bold">Usage Limit</div>
        <div class="font-size-h4 font-weight-bolder">{{$sim?->volume_limit ? $sim->volume_limit . ' GB' : ''}}</div>
    </div>
    <div class="col-lg-12 px-8 pb-6">
        <div class="font-size-sm text-muted font-weight-bold">Usage Remaining</div>
        <div class="font-size-h4 font-weight-bolder">{{$sim?->volume_remaining ? $sim->volume_remaining . ' GB' : ''}}</div>
    </div>
    <div class="col-lg-12 px-8 pb-6">
        <div class="font-size-sm text-muted font-weight-bold">Usage</div>
        <div class="font-size-h4 font-weight-bolder">{{$sim?->volume ? $sim->volume . ' GB' : ''}}</div>
    </div>
</div>