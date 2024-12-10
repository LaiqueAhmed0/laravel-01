@extends('layouts.layout')

@push('content')

    <!--begin::Profile Personal Information-->
    <div class="d-flex flex-row">
    @include('user.partials.aside')
    <!--begin::Content-->
        <div class="flex-row-fluid ml-lg-8">
            <form action="{{Auth::user()->admin() ? '/admin/users/update/'.$user->id : '/profile/update'}}"
                  method="POST">
            @csrf
            <!--begin::Card-->
                <div class="card card-custom card-stretch">
                    <!--begin::Header-->
                    <div class="card-header py-3">
                        <div class="card-title align-items-start flex-column">
                            <h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
                            <span class="text-muted font-weight-bold font-size-sm mt-1">Update your personal information</span>
                        </div>
                        <div class="card-toolbar">
                            <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body">

                        <div class="row">
                            <label class="col-xl-3"></label>
                            <div class="col-lg-9 col-xl-6">
                                <h5 class="font-weight-bold mt-10 mb-6">Contact Info</h5>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">First Name</label>
                            <div class="col-lg-9 col-xl-6">
                                <input name="first_name" class="form-control form-control-lg form-control-solid mb-2" type="text" value="{{$user->first_name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Last Name</label>
                            <div class="col-lg-9 col-xl-6">
                                <input name="last_name" class="form-control form-control-lg form-control-solid mb-2" type="text" value="{{$user->last_name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Company Name</label>
                            <div class="col-lg-9 col-xl-6">
                                <input name="company_name" class="form-control form-control-lg form-control-solid mb-2" type="text" value="{{$user->company_name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Tax Code</label>
                            <div class="col-lg-9 col-xl-6">
                                <input name="tax_code" class="form-control form-control-lg form-control-solid mb-2" type="text" value="{{$user->tax_code}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
                            <div class="col-lg-9 col-xl-6">
                                <input name="phone" type="text" class="form-control form-control-lg form-control-solid mb-2" value="{{$user->phone}}" placeholder="Phone">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                            <div class="col-lg-9 col-xl-6">
                                <input name="email" type="email" class="form-control form-control-lg form-control-solid mb-2" value="{{$user->email}}" placeholder="Email">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-xl-3"></label>
                            <div class="col-lg-9 col-xl-6">
                                <h5 class="font-weight-bold mt-10 mb-6">Address Info</h5>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Address</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="input-group">
                                    <input name="address" type="text" class="form-control form-control-lg form-control-solid mb-2" value="{{$user->address}}" placeholder="Address">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Address 2</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="input-group">
                                    <input name="address_2" type="text" class="form-control form-control-lg form-control-solid mb-2" value="{{$user->address_2}}" placeholder="Address Line 2">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">City</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="input-group">
                                    <input name="city" type="text" class="form-control form-control-lg form-control-solid mb-2" value="{{$user->city}}" placeholder="City">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">County</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="input-group">
                                    <input name="county" type="text" class="form-control form-control-lg form-control-solid mb-2" value="{{$user->county}}" placeholder="County">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Postcode</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="input-group">
                                    <input name="postcode" type="text" class="form-control form-control-lg form-control-solid mb-2" value="{{$user->postcode}}" placeholder="Postcode">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Country</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="input-group">
                                    <select name="country" type="text" class="form-control form-control-lg form-control-solid" selected="{{$user->country}}" placeholder="Country">
                                        @include('components.form.selectCounties')
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        var currentCountry = '{{$user->country}}';
        var value = $("select[name='country'] option[value='" + currentCountry + "']").attr('selected', true);
    </script>

@endpush
