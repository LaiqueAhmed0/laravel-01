<div>
    <x-loader id="loader" wire:loading/>
    <div class="row">
        <div class="col-sm-8 offset-2">
            <div class="form-group row d-flex align-items-center">
                <label class="col-xl-3 col-lg-3 col-form-label">Sims <span class="text-danger">*</span></label>
                <div class="col-lg-9 col-xl-6">
                    <div class="row">
                        <div class="col-lg-6">
                            <span wire:ignore>
                                <select class="form-control selectpicker" wire:model.live="iccid_from" data-live-search="true">
                                    <option value="">Sim *</option>
                                    @foreach($sims as $sim)
                                        <option value="{{$sim->iccid}}">{{$sim->serial_no}}</option>
                                    @endforeach
                                </select>
                            </span>
                            @error('iccid_from')
                                <span class="text-danger mt-5">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6">
                            <span wire:ignore>
                                <select class="form-control selectpicker" wire:model.live="iccid_to" data-live-search="true">
                                    <option value="">Sim Range End</option>
                                    @foreach($sims as $sim)
                                        <option value="{{$sim->iccid}}">{{$sim->serial_no}}</option>
                                    @endforeach
                                </select>
                            </span>
                            @error('iccid_to')
                                <span class="text-danger mt-5">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                @if ($iccid_from && ($iccid_from <= $iccid_to || $iccid_to == null))
                    <div class="col-xl-3">
                        Potential Amount of sims being activated <span class="pl-1">{{($iccid_to ?? $iccid_from) - $iccid_from + 1}}</span>
                    </div>
                @endif
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Starting Plan <span class="text-danger">*</span></label>
                <div class="col-lg-9 col-xl-6">
                    <select class="form-control" wire:model="plan">
                        <option value="">Plan *</option>
                        @foreach($plans as $plan)
                            <option value="{{$plan->id}}">{{$plan->name}}</option>
                        @endforeach
                    </select>
                    @error('plan')
                        <span class="text-danger mt-5">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Retailer</label>
                <div class="col-lg-9 col-xl-6">
                    <select class="form-control" wire:model="retailer">
                        <option value="">Retailer</option>
                        @foreach($retailers as $retailer)
                            <option value="{{$retailer->id}}">{{$retailer->name}}</option>
                        @endforeach
                    </select>
                    @error('retailer')
                        <span class="text-danger mt-5">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end align-items-center w-100">
            <button onclick="areYouSureCreate()" class="btn btn-success" wire:loading.attr="disabled">Create</button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function areYouSureCreate() {
            Swal.fire({
                title: "Are you sure?",
                text: "This will active the sim/sims on Bics and the selected plan is loaded onto the sim.",
                icon: "warning",
                showCancelButton: true,
                dangerMode: true,
            }).then((willDelete) => {
                // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
                if (willDelete.isConfirmed) {
                    Livewire.dispatch('create')
                }
            });
        }

        window.addEventListener('createSuccess', () => {
            Swal.fire(
                'Sims Are Being Created',
                'The sim/sims are being created and will be ready to be used soon.',
                'success'
            )
        });
    </script>
@endpush
