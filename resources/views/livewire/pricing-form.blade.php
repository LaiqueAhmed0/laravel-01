<div class="card card-custom">
    <div class="card-header border-bottom-0 py-3">
        <div class="card-title">
            <h3 class="card-label d-flex flex-column">
                <span class="card-label font-weight-bolder text-dark">Conditions Create</span>

            </h3>
        </div>
        <div class="card-toolbar">
            <button wire:click="create" type="button" class="btn btn-success mr-2">Submit</button>
        </div>
    </div>
    @csrf
    <div class="card-body">

        <div class="mt-5">
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Name:</label>
                <div class="col-lg-6">
                    <input type="text" wire:model.live="name" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($plan) ? $plan->name : old('name')}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Markup:</label>
                <div class="col-lg-6">
                    <input type="text" wire:model.live="markup" class="form-control form-control-lg form-control-solid mb-2" value="{{isset($plan) ? $plan->rate : old('rate')}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Countries:</label>
                <div class="col-lg-6" wire:ignore>
                    <select class="form-control form-control-lg form-control-solid selectpicker" name="countries[]" multiple="multiple" data-live-search="true">
                        @foreach(\App\Models\Country::orderBy('name')->get() as $country)
                            <option {{isset($countries) && in_array($country->id, $countries) ? 'selected="selected"' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Regions:</label>
                <div class="col-lg-6" wire:ignore>
                    <select class="form-control form-control-lg form-control-solid selectpicker" name="countries[]" multiple="multiple" data-live-search="true">
                        @foreach(\App\Models\Region::orderBy('name')->get() as $region)
                            <option {{isset($countries) && in_array($region->id, $regions) ? 'selected="selected"' : ''}} value="{{$region->id}}">{{$region->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row ">
                <label class="col-lg-3 col-form-label">Conditions:</label>
                <div class="col-lg-6">
                    @foreach($conditions as $key => $condition)
                        <div>
                            <div class="d-flex align-items-end" style="gap:5px">
                                <div class="form-group" style="width: 33%">
                                    <label class="col-form-label">Attribute:</label>
                                    <select class="form-control form-control-lg form-control-solid mb-2" wire:model.live="conditions.{{$key}}.attribute">
                                        <option>Please Select</option>
                                        <option>Cost</option>
                                        <option>Allowance</option>
                                        <option>Validity</option>
                                    </select>
                                </div>
                                <div class="form-group" style="width: 33%">
                                    <label class="col-form-label">Operator:</label>
                                    <select class="form-control form-control-lg form-control-solid mb-2" wire:model.live="conditions.{{$key}}.operator">
                                        <option>Please Select</option>
                                        <option>Equal</option>
                                        <option>Not Equal</option>
                                        <option>Less Than</option>
                                        <option>Less Than or Equal</option>
                                        <option>More Than</option>
                                        <option>More Than or Equal</option>
                                    </select>
                                </div>
                                <div class="form-group" style="width: 33%">
                                    <label class="col-form-label">Value:</label>
                                    <input type="text" wire:model.live="conditions.{{$key}}.value" class="form-control form-control-lg form-control-solid mb-2" value="">
                                </div>
                                <button wire:click="removeCondition({{$key}})" style="margin-bottom: 32px;" type="button" class="btn btn-danger btn-icon">
                                    <svg fill="none" style="height: 22px;" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                    </svg>
                                    <span class="sr-only">Icon description</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                    <div>
                        <div class="d-flex align-items-end" style="gap:5px">
                            <div class="form-group" style="width: 33%">
                                <label class="col-form-label">Attribute:</label>
                                <select class="form-control form-control-lg form-control-solid mb-2" wire:model.live="new_condition.attribute">
                                    <option>Please Select</option>
                                    <option>Cost</option>
                                    <option>Allowance</option>
                                    <option>Validity</option>
                                </select>
                            </div>
                            <div class="form-group" style="width: 33%">
                                <label class="col-form-label">Operator:</label>
                                <select class="form-control form-control-lg form-control-solid mb-2" wire:model.live="new_condition.operator">
                                    <option>Please Select</option>
                                    <option>Equal</option>
                                    <option>Not Equal</option>
                                    <option>Less Than</option>
                                    <option>Less Than or Equal</option>
                                    <option>More Than</option>
                                    <option>More Than or Equal</option>
                                </select>
                            </div>
                            <div class="form-group" style="width: 33%">
                                <label class="col-form-label">Value:</label>
                                <input type="text" wire:model.live="new_condition.value" class="form-control form-control-lg form-control-solid mb-2" value="">
                            </div>
                            <button wire:click="addCondition" style="margin-bottom: 32px;" type="button" class="btn btn-success btn-icon">
                                <svg fill="none" stroke="currentColor" height="22px" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                                </svg>
                                <span class="sr-only">Icon description</span>
                            </button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@push('head')
    <style>
        .bootstrap-select > .dropdown-toggle.btn-light, .bootstrap-select > .dropdown-toggle.btn-secondary {
            height: 44px !important;
        }

        .bootstrap-select > .dropdown-toggle.btn-light .filter-option, .bootstrap-select > .dropdown-toggle.btn-secondary .filter-option {
            height: 21px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $('.selectpicker').on('change', function () {
            var selected = []; //array to store value
            $(this).find("option:selected").each(function (key, value) {
                selected.push($(value).val()); //push the text to array
            });
            Livewire.dispatch('countriesUpdated', selected)
        });
    </script>
@endpush

