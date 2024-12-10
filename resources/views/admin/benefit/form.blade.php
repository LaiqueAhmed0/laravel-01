@extends('layouts.layout', ['subHeader' => 'Benefit Creation'])

@push('content')
    <div class="row">
        <div class="col-sm-8 offset-2">
            <form id="planCreate" class="card card-custom" action="/admin/benefits" method="post" enctype="multipart/form-data">
                <div class="card-header border-bottom-0 py-3">
                    <div class="card-title">
                        <h3 class="card-label d-flex flex-column">
                            <span class="card-label font-weight-bolder text-dark">Benefit Create</span>

                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <button id="submitBtn" type="submit" class="btn btn-success mr-2">Submit</button>
                    </div>
                </div>
                @csrf
                <div class="card-body">
                    <div class="mt-5">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Type:</label>
                            <div class="col-lg-6">
                                <select class="form-control form-control-lg form-control-solid selectpicker" name="type">
                                    <option>Single Country/Region</option>
                                    <option>Hybrid</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row d-flex align-items-center">
                            <label class="col-lg-3 col-form-label">Data: <input type="text" class="form-control" id="kt_nouislider_2_input" name="data" placeholder="Data"/></label>
                            <div class="col-lg-6">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <div id="kt_nouislider_2" class="nouislider nouislider-handle-danger"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row d-flex align-items-center">
                            <label class="col-lg-3 col-form-label">Length: <input type="text" class="form-control" id="kt_nouislider_3_input" name="length" placeholder="Length"/></label>
                            <div class="col-lg-6">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <div id="kt_nouislider_3" class="nouislider nouislider-handle-danger"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="hybrid" style="display: none">
                            <div class="form-group row d-flex align-items-center">
                                <label class="col-lg-3 col-form-label">Hybrid Countries:</label>
                                <div class="col-lg-6">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <select class="form-control form-control-lg form-control-solid selectpicker" name="country_1" data-live-search="true">
                                                @foreach($countries as $country)
                                                    <option {{isset($plan) && in_array($country->id, $plan->countries) ? 'selected="selected"' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <select class="form-control form-control-lg form-control-solid selectpicker" name="country_2" data-live-search="true">
                                                @foreach($countries as $country)
                                                    <option {{isset($plan) && in_array($country->id, $plan->countries) ? 'selected="selected"' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row d-flex align-items-center">
                                <label class="col-lg-3 col-form-label d-flex justify-content-between flex-column">Hybrid Split: <input type="hidden" class="form-control" id="kt_nouislider_4_input" placeholder="Currency"/>
                                    <div class="text-right">
                                        <span class="badge badge-info" id="country_1_hybrid"></span>
                                    </div>
                                </label>
                                <div class="col-lg-6">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <div id="kt_nouislider_4" style="margin-top: 20px;" class="nouislider nouislider-handle-danger"></div>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-lg-3 col-form-label"><span style="margin-top: 20px;" class="badge badge-info" id="country_2_hybrid"></span></label>
                            </div>
                        </div>

                        <div id="single">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Country:</label>
                                <div class="col-lg-6">
                                    <select class="form-control form-control-lg form-control-solid selectpicker" name="country" data-live-search="true">
                                        @foreach($countries as $country)
                                            <option {{isset($plan) && in_array($country->id, $plan->countries) ? 'selected="selected"' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>

            $('[name="country_1"]').on('change', function () {
                $('#country_1_hybrid').html($(this).find('option:selected').text());
            });

            $('[name="country_2"]').on('change', function () {
                $('#country_2_hybrid').html($(this).find('option:selected').text());
            });

            $('[name="type"]').on('change', function () {
                if ($(this).find('option:selected').val() === "Single Country/Region") {
                    $('#single').show();
                    $('#hybrid').hide();
                } else {
                    $('#single').hide();
                    $('#hybrid').show();
                }
            });


            function dataSlider() {
                var slider = document.getElementById('kt_nouislider_2');

                noUiSlider.create(slider, {
                    start: [1000],
                    connect: [true, false],
                    step: 100,
                    range: {
                        'min': [100],
                        'max': [100000]
                    },
                    format: wNumb({
                        decimals: 0,
                        thousand: ',',
                        postfix: ' MB',
                    })
                });

                // init slider input
                var sliderInput = document.getElementById('kt_nouislider_2_input');

                slider.noUiSlider.on('update', function (values, handle) {
                    sliderInput.value = values[handle];
                });

                sliderInput.addEventListener('change', function () {
                    slider.noUiSlider.set(this.value);
                });
            }

            function lengthSlider() {
                var slider = document.getElementById('kt_nouislider_3');

                noUiSlider.create(slider, {
                    start: [1],
                    connect: [true, false],
                    step: 1,
                    range: {
                        'min': [1],
                        'max': [365]
                    },
                    format: wNumb({
                        decimals: 0,
                        thousand: ',',
                        postfix: ' Days',
                    })
                });

                // init slider input
                var sliderInput = document.getElementById('kt_nouislider_3_input');

                slider.noUiSlider.on('update', function (values, handle) {
                    sliderInput.value = values[handle];
                });

                sliderInput.addEventListener('change', function () {
                    slider.noUiSlider.set(this.value);
                });
            }

            function hybridSlider() {
                var slider = document.getElementById('kt_nouislider_4');

                noUiSlider.create(slider, {
                    start: [50],
                    connect: false,
                    step: 1,
                    range: {
                        'min': [1],
                        'max': [100]
                    },
                    tooltips: wNumb({
                        decimals: 0,
                        thousand: ',',
                        postfix: ' %',
                    })
                });

                // init slider input
                var sliderInput = document.getElementById('kt_nouislider_4_input');

                slider.noUiSlider.on('update', function (values, handle) {
                    sliderInput.value = values[handle];
                });

                sliderInput.addEventListener('change', function () {
                    slider.noUiSlider.set(this.value);
                });
            }

            dataSlider();
            hybridSlider();
            lengthSlider();

        </script>

    @endpush

@endpush