@extends('layouts.layout')

@push('content')

    <style>
        .invalid-feedback {
            display: block !important;
        }
    </style>

    <!--begin::Profile Personal Information-->
    <div class="d-flex flex-row">
    @include('user.partials.aside')
    <!--begin::Content-->
        <div class="flex-row-fluid ml-lg-8">
            <form action="{{Auth::user()->admin() ? '/admin/users/update-password/'.$user->id : '/profile/update-password'}}" method="POST">
            @csrf
            <!--begin::Card-->
                <div class="card card-custom card-stretch">
                    <!--begin::Header-->
                    <div class="card-header py-3">
                        <div class="card-title align-items-start flex-column">
                            <h3 class="card-label font-weight-bolder text-dark">Change Password</h3>
                            <span class="text-muted font-weight-bold font-size-sm mt-1">Change or reset your account password</span>
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
                                <h5 class="font-weight-bold mt-10 mb-6">
                                    Change Or Recover Your Password
                                </h5>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Current Password</label>
                            <div class="col-lg-9 col-xl-6">
                                <input type="password" class="form-control form-control-lg form-control-solid mb-2" name="current_password" value="" placeholder="Current password" autocomplete="off">

                                @error('current_password')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">New Password</label>
                            <div class="col-lg-9 col-xl-6">
                                <input type="password" name="password" class="form-control form-control-lg form-control-solid mb-2" value="" placeholder="New password">
                                <small>The password must be 8 to 20 characters long, include numbers and uppercase
                                    letters</small>
                                @error('password')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group form-group-last row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Verify Password</label>
                            <div class="col-lg-9 col-xl-6">
                                <input type="password" class="form-control form-control-lg form-control-solid mb-2" name="password_confirmation" value="" placeholder="Verify password">
                                @error('password_confirmation')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endpush
