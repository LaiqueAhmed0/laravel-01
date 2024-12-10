@extends('layouts.layout')

@push('content')
    <div class="row">
        <div class="col-sm-8 offset-2">
            <form id="planCreate" class="card card-custom" action="/admin/regions{{isset($region) ? '/'.$region->id : ''}}" method="post" enctype="multipart/form-data">
                <div class="card-header border-bottom-0 py-3">
                    <div class="card-title">
                        <h3 class="card-label d-flex flex-column">
                            <span class="card-label font-weight-bolder text-dark">Region Create/Edit</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button id="submitBtn" type="button" class="btn btn-success mr-2">Submit</button>
                    </div>
                </div>
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Name:</label>
                        <div class="col-lg-6">
                            <input type="text" name="name" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($region) ? $region->name : old('name')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Countries:</label>
                        <div class="col-lg-6">
                            <select class="form-control form-control-lg form-control-solid selectpicker" name="countries[]" multiple="multiple" data-live-search="true">
                                @foreach(\App\Models\Country::orderBy('name')->get() as $country)
                                    <option {{isset($region) && in_array($country->id, ($region->countries->pluck('id')->toArray() ?? [])) ? 'selected="selected"' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
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
                    countiesString += '<li>' + countriesInput.children(`option[value="${country}"]`).html() + '</li>';
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