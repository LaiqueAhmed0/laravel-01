<div>
    <div class="row" x-data="customplan" >
        <div class="col-sm-8 offset-2">
            <div class="card card-custom gutter-b">
                <div class="card-header border-0 pt-5 d-flex justify-content-center" style="min-height: 10px !important; ">
                    <div class="card-label">
                        <h2 class="card-title font-weight-bolder text-black text-center">My Custom Plan</h2>
                    </div>
                </div>
                <!--begin::Body-->
                <div class="card-body p-10 my-8">
                    <div class="row">
                        <div class="form-group col-6"  >
                            <label style="min-height: 39px">Sim Iccid</label>
                            <div wire:ignore>
                                <select id="iccid" class="form-control" name="iccid">
                                    @if(Auth::user()->group == 3)
                                        @foreach(\App\Models\Sim::get() as $sim)
                                            <option value="{{$sim->iccid}}">{{$sim->iccid}}</option>
                                        @endforeach
                                    @elseif(Auth::user()->group == 2)
                                        @foreach(\App\Models\Sim::where('retailer_id', Auth::user()->retailer_id)->get() as $sim)
                                            <option value="{{$sim->iccid}}">{{$sim->iccid}}</option>
                                        @endforeach
                                    @else
                                        @foreach(Auth::user()->sims as $sim)
                                            <option value="{{$sim->iccid}}">{{$sim->iccid}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                        </div>
                        <div class="form-group col-6">
                            <label>Scheduled Date<br>(Select bundle start date)</label>
                            <div class="input-group date">
                                <input type="date" class="form-control " name="date" wire:model.live="date">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-4">
                            <label>Countries</label>
                            <div class="d-flex" style="gap: 10px" >
                                <div wire:ignore>
                                    <select id="countries" multiple class="form-control" name="countries">
                                        <option default="default" disabled="disabled">Please Select</option>
                                        @foreach(\App\Models\Country::where('operators', '!=', null)->where('operators', '!=', '[]')->orderBy('name', 'ASC')->get() as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <button class="btn btn-primary" onclick="jQuery('#countries').select2('open')">Add Country</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-4">
                            <label>Data</label>
                            <div class="input-group">
                                <input class="form-control" type="number" min="1" max="100" name="data" wire:model.live="data">
                                <div class="input-group-append">
                                    <span class="input-group-text">GB</span>
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-4">
                            <label>Length</label>
                            <div class="input-group">
                                <input class="form-control" type="number" min="60" max="730" step="5" name="length" wire:model.live="length">
                                <div class="input-group-append">
                                    <span class="input-group-text">Days</span>
                                </div>

                            </div>
                            <p>Max 2 years. Surcharge of 3p per day after 60 days apply.</p>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-around text-center mt-10">
                        <div class="d-flex flex-column"><span class="font-size-lg font-weight-bold">Subtotal</span><span class="font-size-lg font-weight-bolder">£{{number_format($rate/100, 2)}}</span></div>
                    </div>

                    <div class="d-flex justify-content-center mt-10">
                        <button class="btn btn-primary" wire:click="addToCart">Add To Basket</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

@script
<script>
    Alpine.data('customplan', () => {
        return {

            init() {
                $('[name="date"]').on('change', (e) => {
                    this.$wire.dispatch('dateUpdated', $(e.target).val())
                });

                $('#countries').select2();
                $('#countries').on('change',  (e) => {
                    this.$wire.dispatch('countriesUpdated', {countries: $('#countries').val()})
                });
                $('#iccid').select2();
                $('#iccid').on('change',  (e) => {
                    this.$wire.dispatch('iccidUpdated', {iccid: $('#iccid').val()})
                });

                this.$wire.on('cartRefresh', () => {
                    Swal.fire({
                        title: 'Item ' +
                            'added to basket!',
                        text: '',
                        type: 'success',
                        showCancelButton: true,
                        cancelButtonText: 'Continue',
                        confirmButtonText: 'Checkout',
                    }).then(function (result) {
                        if (result.value) {
                            window.location.href = '/checkout';
                        } else {
                            location.reload();
                        }
                    });
                    getCart();
                })

            }
        }
    })

</script>
@endscript

