@extends('layouts.layout')

@push('content')
    <div class="row">
        <div class="col-sm-8 offset-2">
            <form id="planCreate" class="card card-custom" action="/admin/countries/{{$country->id}}" method="post" enctype="multipart/form-data">
                <div class="card-header border-bottom-0 py-3">
                    <div class="card-title">
                        <h3 class="card-label d-flex flex-column">
                            <span class="card-label font-weight-bolder text-dark">Country Edit</span>
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
                            <label class="col-lg-3 col-form-label">Name:</label>
                            <div class="col-lg-6">
                                <input type="text" name="name" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($country) ? $country->name : old('name')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Price Per MB:</label>
                            <div class="col-lg-6">
                                <input type="text" name="price_per_mb" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($country) ? $country->price_per_mb : old('price_per_mb')}}">
                            </div>
                        </div>

                        <div  class="mb-5 font-size-lg"><b>Operators Unique Price (Leave empty to default to above price per MB)</b></div>

                        @foreach(json_decode($country->operators, true) as $key => $operator)
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">{{$operator['name']}}</label>
                                <div class="col-lg-6">
                                    <input type="text" name="operator[{{$key}}]" class="form-control form-control-lg form-control-solid mb-2" value="{{$operator['price'] ?? null}}">
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#submitBtn').on('click', function () {
                Swal.fire({
                    title: 'Confirm Update',
                    html: `You are about to update this country, are you sure you wish to continue?`,
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