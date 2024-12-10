@extends('layouts.layout')

@push('content')
    <div class="row">
        <div class="col-sm-8 offset-2">
            <form id="planCreate" class="card card-custom" action="/admin/plans{{isset($plan) ? '/'.$plan->id : ''}}" method="post" enctype="multipart/form-data">
                <div class="card-header border-bottom-0 py-3">
                    <div class="card-title">
                        <h3 class="card-label d-flex flex-column">
                            <span class="card-label font-weight-bolder text-dark">Plan Create/Edit</span>

                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button id="submitBtn" type="button" class="btn btn-success mr-2">Submit</button>
                    </div>
                </div>
                @csrf
                <div class="card-body">

                    <div class="mt-5">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Bics IDs:</label>
                            <div class="col-lg-6">
                                <select class="form-control form-control-lg form-control-solid selectpicker" name="bics_id[]" multiple="multiple" data-live-search="true">
                                    @foreach(\App\Facades\Bics\Bics::getPlans()->Response->responseParam->plan as $item)
                                        <option {{isset($plan) && $plan->bics_id && in_array($item->basicInfo->planId, $plan->bics_id) ? 'selected="selected"' : ''}}  value="{{$item->basicInfo->planId}}">
                                            {{$item->basicInfo->planName}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Name:</label>
                            <div class="col-lg-6">
                                <input type="text" name="name" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($plan) ? $plan->name : old('name')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Price (In Pennies):</label>
                            <div class="col-lg-6">
                                <input type="text" name="rate" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($plan) ? $plan->rate : old('rate')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Allowance (MB):</label>
                            <div class="col-lg-6">
                                <input type="text" name="credit" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($plan) ? $plan->credit : old('credit')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Validity (Days):</label>
                            <div class="col-lg-6">
                                <input type="text" name="length" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($plan) ? $plan->length : old('length')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Hybrid:</label>
                            <div class="col-lg-6">
                                <input type="checkbox" {{isset($plan) && $plan->hybrid ? 'checked="checked"' : ''}} name="hybrid" class="form-control mb-2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Featured:</label>
                            <div class="col-lg-6">
                                <input type="checkbox" {{isset($plan) && $plan->featured ? 'checked="checked"' : ''}} name="featured" class="form-control mb-2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Show On Catalog:</label>
                            <div class="col-lg-6">
                                <input type="checkbox" name="type" {{isset($plan) && $plan->type == 'admin' ? 'checked="checked"' : ''}} class="form-control mb-2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Fixed Price:</label>
                            <div class="col-lg-6">
                                <input type="checkbox" name="fixed_price" {{isset($plan) && $plan->fixed_price == 'admin' ? 'checked="checked"' : ''}} class="form-control mb-2">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Countries:</label>
                            <div class="col-lg-6">
                                <select class="form-control form-control-lg form-control-solid selectpicker" name="countries[]" multiple="multiple" data-live-search="true">
                                    @foreach(\App\Models\Country::orderBy('name')->get() as $country)
                                        <option {{isset($plan) && in_array($country->id, $plan->countries) ? 'selected="selected"' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#submitBtn').on('click', function () {
                const countriesInput = $('[name="countries[]"]');
                let countiesString = '';
                for (let country of countriesInput.val()) {
                    countiesString += '<li>'+countriesInput.children(`option[value="${country}"]`).html()+'</li>';
                }
                countiesString = countiesString.slice(0, -2)

                Swal.fire({
                    title: 'Confirm countries',
                    html: `You have selected the following countries: <ol class="text-left max-h-100px overflow-auto">${countiesString}</ol>`,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#1e2252',
                    cancelButtonColor: '#ff308f',
                    confirmButtonText: `Confirm`,
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    //if user clicks on delete
                    if (result.value) {

                        $('form#planCreate').submit();
                    } else {
                        // responseAlert({
                        //     title: 'Operation Cancelled!',
                        //     type: 'success'
                        // });
                    }
                });
            });
        </script>

    @endpush

@endpush