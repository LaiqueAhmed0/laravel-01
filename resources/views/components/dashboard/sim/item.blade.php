
<!--begin::Base Table Widget 1-->
<div class="card card-custom gutter-b">

    <!--begin::Body-->
    <div class="card-body pt-15 pb-5 mt-n3 d-flex justify-content-between flex-wrap align-items-center">
        <div class="w-20" >
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark">{{$item->iccid}}</span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm">
                <span class="text-muted font-weight-bold d-block"><a class="nickname">{!!$item->nickname ?? 'Add Nickname'!!}</a>
                    <form class="bm-popover" method="POST" action="/sim/{{$item->iccid}}/nickname" style="display: none">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="nickname" class="form-control" placeholder="Nickname" value="{{$item->nickname}}">
                        <div class="input-group-append">
                            <button class="btn btn-info btn-icon" type="submit"><i class="la la-save"></i></button>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-danger btn-icon nickname-close" type="button"><i class="la la-times"></i></button>
                        </div>
                    </div>
                    </form>
                </span>
            </span>
            </h3>
        </div>
        <div class="w-20 pb-5">
            <div class="font-weight-bold font-size-lg mb-2">
                Status
            </div>
            <div class="badge badge-success">
                {{$item->status ? 'Active' : 'Inactive'}}
            </div>
        </div>
        <div class="w-20 pb-5">
            <div class="font-weight-bold font-size-lg mb-2 ">
                Usage Limit
            </div>
            <div class="badge badge-danger">
                {{$item->volume_limit ?? 'No Plan'}} MB
            </div>
        </div>
        <div class="w-20  pb-5">
            <div class="font-weight-bold font-size-lg mb-2">
                Remaining Usage
            </div>
            <div  class="badge badge-warning">
                {{$item->volume_remaining ?? 0}} MB
            </div>
        </div>
        <div class="w-20  pb-5">
            <div class="font-weight-bold font-size-lg mb-2">
                Usage
            </div>
            <div  class="badge badge-primary">
                {{$item->volume ?? 0}} MB
            </div>
        </div>
        <div class="w-20 text-right pb-5">
            <a href="/dashboard/{{$item->iccid}}" class="btn btn-primary btn-sm">
                View Usage
            </a>
            <button onclick="removeUserSimAreYouSure({{$item->id}})" class="btn btn-danger btn-sm">
                Remove
            </button>
        </div>
    </div>
</div>
<!--end::Base Table Widget 1-->
  
        