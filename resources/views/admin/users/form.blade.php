@extends('layouts.layout', ['subHeader' => 'User Form'])

@push('content')
    <div class="row">
        <div class="col-sm-8 offset-2">
            <form class="card card-custom" action="/admin/users{{isset($user) ? "/{$user->id}" : ''}}" method="post" enctype="multipart/form-data">
                <div class="card-header border-bottom-0 py-3">
                    <div class="card-title">
                        <h3 class="card-label d-flex flex-column">
                            <span class="card-label font-weight-bolder text-dark">User Edit</span>

                        </h3>
                    </div>
                    <div class="card-toolbar">

                    </div>
                </div>
                @csrf
                <div class="card-body">
                    <div class="row">
                        <label class="col-xl-3"></label>
                        <div class="col-lg-9 col-xl-6">
                            <h5 class="font-weight-bold mb-6">Contact Info</h5>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">First Name <span class="text-danger">*</span></label>
                        <div class="col-lg-9 col-xl-6">
                            <input name="first_name" class="form-control form-control-lg form-control-solid mb-2" type="text" value="{{isset($user) ? $user->first_name : old('first_name')}}" placeholder="First Name">
                            @error('first_name')
                                <span class="text-danger mt-2">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Last Name <span class="text-danger">*</span></label>
                        <div class="col-lg-9 col-xl-6">
                            <input name="last_name" class="form-control form-control-lg form-control-solid mb-2" type="text" value="{{isset($user) ? $user->last_name : old('last_name')}}" placeholder="Last Name">
                            @error('last_name')
                            <span class="text-danger mt-2">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Company Name</label>
                        <div class="col-lg-9 col-xl-6">
                            <input name="company_name" class="form-control form-control-lg form-control-solid mb-2" type="text" value="{{isset($user) ? $user->company_name : old('company_name')}}" placeholder="Company Name">
                            @error('company_name')
                                <span class="text-danger mt-2">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Tax Code</label>
                        <div class="col-lg-9 col-xl-6">
                            <input name="tax_code" class="form-control form-control-lg form-control-solid mb-2" type="text" value="{{isset($user) ? $user->tax_code : old('tax_code')}}" placeholder="Tax Code">
                            @error('tax_code')
                                <span class="text-danger mt-2">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
                        <div class="col-lg-9 col-xl-6">
                            <input name="phone" type="text" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($user) ? $user->phone : old('phone')}}" placeholder="Phone">
                            @error('phone')
                                <span class="text-danger mt-2">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Email Address <span class="text-danger">*</span></label>
                        <div class="col-lg-9 col-xl-6">
                            <input name="email" type="email" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($user) ? $user->email : old('email')}}" placeholder="Email">
                            @error('email')
                                <span class="text-danger mt-2">{{$message}}</span>
                            @enderror
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
                                <input name="address" type="text" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($user) ? $user->address : old('address')}}" placeholder="Address">
                                @error('address')
                                <span class="text-danger mt-2">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Address 2</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group">
                                <input name="address_2" type="text" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($user) ? $user->address_2 : old('address_2')}}" placeholder="Address Line 2">
                                @error('address_2')
                                <span class="text-danger mt-2">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">City</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group">
                                <input name="city" type="text" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($user) ? $user->city : old('city')}}" placeholder="City">
                                @error('city')
                                <span class="text-danger mt-2">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">County</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group">
                                <input name="county" type="text" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($user) ? $user->county : old('county')}}" placeholder="County">
                                @error('county')
                                <span class="text-danger mt-2">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Postcode</label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group">
                                <input name="postcode" type="text" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($user) ? $user->postcode : old('postcode')}}" placeholder="Postcode">
                                @error('postcode')
                                <span class="text-danger mt-2">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Country <span class="text-danger">*</span></label>
                        <div class="col-lg-9 col-xl-6">
                            <div class="input-group">
                                <select name="country" type="text" class="form-control form-control-lg form-control-solid" selected="{{isset($user) ? $user->country : old('country')}}" placeholder="Country">
                                    @include('components.form.selectCounties')
                                </select>
                                @error('country')
                                <span class="text-danger mt-2">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-xl-3"></label>
                        <div class="col-lg-9 col-xl-6">
                            <h5 class="font-weight-bold mt-10 mb-6">Security</h5>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Password @if(!isset($user))<span class="text-danger">*</span>@endif</label>
                        <div class="col-lg-9 col-xl-6">
                            <input type="password" name="password" class="form-control form-control-lg form-control-solid mb-2" value="" placeholder="Password">
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
                    <div class="row">
                        <label class="col-xl-3"></label>
                        <div class="col-lg-9 col-xl-6">
                            <h5 class="font-weight-bold mt-10 mb-6">System Details</h5>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Group:</label>
                            <div class="col-lg-6">
                                <select class="form-control form-control-lg form-control-solid selectpicker" name="group">
                                    <option {{isset($user) && 1 == $user->group ? 'selected="selected"' : ''}} value="1">
                                        Customer
                                    </option>
                                    <option {{isset($user) && 2 == $user->group ? 'selected="selected"' : ''}} value="2">
                                        Retailer
                                    </option>
                                    <option {{isset($user) && 3 == $user->group ? 'selected="selected"' : ''}} value="3">
                                        Admin
                                    </option>
                                </select></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Retailer:</label>
                            <div class="col-lg-6">
                                <select class="form-control form-control-lg form-control-solid selectpicker" name="retailer_id">
                                    <option value="">None</option>
                                    @foreach(\App\Models\Retailer::all() as $retailer)
                                        <option {{isset($user) && $retailer->id == $user->retailer_id ? 'selected="selected"' : ''}} value="{{$retailer->id}}">
                                            {{$retailer->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success pull-right">Submit</button>
                </div>
            </form>
        </div>
    </div>


@endpush

@push('scripts')
    <script>
        var input = document.getElementById('kt_tagify_1');
        var tagify = new Tagify(input);
    </script>
    @isset($user)
        <script>
            var currentCountry = '{{$user->country}}';
            var value = $("select[name='country'] option[value='" + currentCountry + "']").attr('selected', true);
        </script>
    @endisset
@endpush