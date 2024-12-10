@extends('layouts.layout')

@push('content')
    <div class="row">
        <div class="col-sm-8 offset-2">
            <form class="card card-custom" action="/admin/retailers/create" method="post">
                @csrf
                <div class="card-header border-bottom-0 py-3">
                    <div class="card-title">
                        <h3 class="card-label d-flex flex-column">
                            <span class="card-label font-weight-bolder text-dark">Retailer Creation</span>
                            <span class="text-muted font-weight-bold font-size-sm mt-1">Add a new retailer</span>
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button type="submit" class="btn btn-success mr-2">Create</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mt-5">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Name:<span class="text-danger">*</span></label>
                            <div class="col-lg-6">
                                <input type="text" name="name" class="form-control form-control-lg form-control-solid mb-2 required" required placeholder="Enter Retailer Name" value="">
                                @error('name')
                                <span class="text-danger mt-2">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Address:</label>
                            <div class="col-lg-6">
                                <input type="text" name="address" class="form-control form-control-lg form-control-solid mb-2" placeholder="Enter Retailer Address" value="">
                                @error('address')
                                <span class="text-danger mt-2">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Address Line 2:</label>
                            <div class="col-lg-6">
                                <input type="text" name="address_2" class="form-control form-control-lg form-control-solid mb-2" placeholder="Enter Retailer Address Line 2" value="">
                                @error('address_2')
                                <span class="text-danger mt-2">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Postcode:</label>
                            <div class="col-lg-6">
                                <input type="text" name="postcode" class="form-control form-control-lg form-control-solid mb-2" placeholder="Enter Retailer Postcode" value="">
                                @error('postcode')
                                <span class="text-danger mt-2">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">City:</label>
                            <div class="col-lg-6">
                                <input type="text" name="city" class="form-control form-control-lg form-control-solid mb-2" placeholder="Enter Retailer City" value="">
                                @error('city')
                                <span class="text-danger mt-2">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">County:</label>
                            <div class="col-lg-6">
                                <input type="text" name="county" class="form-control form-control-lg form-control-solid mb-2" placeholder="Enter Retailer County" value="">
                                @error('county')
                                <span class="text-danger mt-2">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Country:</label>
                            <div class="col-lg-6">
                                <select name="country" type="text" class="form-control form-control-lg form-control-solid mb-2 required" placeholder="Country">
                                    @include('components.form.selectCounties')
                                </select>
                                @error('country')
                                <span class="text-danger mt-2">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endpush