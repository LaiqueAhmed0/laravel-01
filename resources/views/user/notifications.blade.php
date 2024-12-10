@extends('layouts.layout')

@push('content')
    <div class="d-flex flex-row">
        @include('user.partials.aside')
        <div class="flex-row-fluid ml-lg-8">
            <div class="row">
                <div class="col-xl-12">
                    <form class="kt-form kt-form--label-right" action="/profile/update-settings" method="post">
                        <div class="card card-custom card-stretch">
                            <!--begin::Header-->
                            <div class="card-header py-3">
                                <div class="card-title align-items-start flex-column">
                                    <h3 class="card-label font-weight-bolder text-dark">Email Notifications</h3>
                                    <span class="text-muted font-weight-bold font-size-sm mt-1">control when and how often Love Mobile Data sends emails to you</span>
                                </div>
                                <div class="card-toolbar">
                                    <button type="submit" class="btn btn-success mr-2">Save Changes</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                            <!--end::Header-->

                            @csrf
                            <div class="card-body">
                                <div class="row mt-5">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-xl-6 col-lg-6 col-form-label">Allow Email Notifications</label>
                                            <div class="col-lg-6 col-xl-6">
                                        <span class="switch">
                                            <label>
                                                 <input type="checkbox" {{!empty($settings['allow_notification']) && $settings['allow_notification'] == 'on'  ? 'checked="checked"' : ''}} name="allow_notification"/>
                                                 <span></span>
                                            </label>
                                       </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-xl-6 col-lg-6 col-form-label">Notify Me At 50% Of Data Used</label>
                                            <div class="col-lg-9 col-xl-6">
                                         <span class="switch">
                                            <label>
                                                 <input type="checkbox" {{!empty($settings['notify_when_50_remaining']) && $settings['notify_when_50_remaining'] == 'on'  ? 'checked="checked"' : ''}} name="notify_when_50_remaining"/>
                                                 <span></span>
                                            </label>
                                       </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-xl-6 col-lg-6 col-form-label">Notify Me At 90% Of Data Used</label>
                                            <div class="col-lg-6 col-xl-6">
                                        <span class="switch">
                                            <label>
                                                 <input type="checkbox" {{!empty($settings['notify_when_10_remaining']) && $settings['notify_when_10_remaining'] == 'on'  ? 'checked="checked"' : ''}} name="notify_when_10_remaining"/>
                                                 <span></span>
                                            </label>
                                       </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-xl-6 col-lg-6 col-form-label" style="text-transform: capitalize">Notify me when my data plan<br>has 2 days remaining</label>
                                            <div class="col-lg-6 col-xl-6">
                                        <span class="switch">
                                            <label>
                                                 <input type="checkbox" {{!empty($settings['notify_when_data_plan_ending']) && $settings['notify_when_data_plan_ending'] == 'on'  ? 'checked="checked"' : ''}} name="notify_when_data_plan_ending"/>
                                                 <span></span>
                                            </label>
                                       </span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-xl-6 col-lg-6 col-form-label" style="text-transform: capitalize">Notify me when my data plan<br>has 1 day remaining</label>
                                            <div class="col-lg-6 col-xl-6">
                                        <span class="switch">
                                            <label>
                                                 <input type="checkbox" {{!empty($settings['notify_when_data_plan_ends']) && $settings['notify_when_data_plan_ends'] == 'on'  ? 'checked="checked"' : ''}} name="notify_when_data_plan_ends"/>
                                                 <span></span>
                                            </label>
                                       </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        $('input[type="checkbox"][name="allow_notification"]').change(function () {
            var value = $(this).val();
            console.log(value);
        });
    </script>
@endpush
