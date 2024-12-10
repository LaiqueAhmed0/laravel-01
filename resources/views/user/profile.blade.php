@extends('layouts.layout')

@section('content')

    <div class="row">
        <div class="col-8 offset-2">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Change Profile Settings
                        </h3>
                    </div>
                </div>
                <form class="kt-form" method="POST" action="/profile/update">
                    <div class="kt-portlet__body">
                        @csrf
                        @component('components.form.text', ['label' => 'Name', 'name' => 'name', 'type' => 'text', 'value' => $user->name]) @endcomponent
                        @component('components.form.text', ['label' => 'Email', 'name' => 'email', 'type' => 'text', 'value' => $user->email]) @endcomponent
                        @component('components.form.text', ['label' => 'Phone', 'name' => 'phone', 'type' => 'text', 'value' => $user->phone]) @endcomponent
                        @component('components.form.text', ['label' => 'House Number', 'name' => 'house_number', 'type' => 'text', 'value' => $user->house_number]) @endcomponent
                        @component('components.form.text', ['label' => 'Postcode', 'name' => 'postcode', 'type' => 'text', 'value' => $user->postcode]) @endcomponent
                        <input name="id" value="{{$user->id}}" type="hidden">
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <a href="/dashboard" class="btn btn-outline-primary">Back</a>
                            <button type="submit" class="btn btn-primary pull-right">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
