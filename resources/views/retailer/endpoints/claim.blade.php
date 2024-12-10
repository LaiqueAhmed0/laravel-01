@extends('layouts.layout')

@section('content')
    <!--Begin::Section-->
    <div class="row">
        <div class="offset-4 col-xl-4">
            <div class="row row-full-height">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="kt-portlet kt-portlet--border-bottom-brand">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    Register Your Sim
                                </h3>
                            </div>
                        </div>
                        <form class="kt-form" method="POST" action="/sim/register">
                            <div class="kt-portlet__body">
                                @csrf
                                @component('components.form.text', ['label' => 'Sim Card ID ( Begins with 8932 )', 'name' => 'iccid', 'type' => 'number', 'min' => 89320420000000000000])
                                @endcomponent
                                @component('components.form.text', ['label' => 'Confirm Sim Card ID', 'name' => 'iccid_confirmation', 'type' => 'number'])
                                @endcomponent
                                @if ($errors->any())
                                    <div class="invalid-feedback" style="display: block;font-size: 14px; font-weight: 400;">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}<br>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::Section-->
@endsection
