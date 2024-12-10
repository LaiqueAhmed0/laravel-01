<div>
    <div class="row">
        <div class="col-sm-8 offset-2">
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Sim <span class="text-danger">*</span></label>
                <div wire:ignore class="col-lg-9 col-xl-6">
                    <select class="form-control selectpicker" wire:model.live="dropdown_iccid" data-live-search="true">
                        <option value="null">Please Select</option>
                        @foreach($sims as $sim)
                            <option value="{{$sim['endpointId']}}">{{$sim['serial_no']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="text-center text-muted text-uppercase fw-bolder mb-5">or</div>
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Sim Range <span class="text-danger">*</span></label>
                <div class="col-lg-9 col-xl-6">
                    <div class="row">
                        <div wire:ignore class="col-lg-6">
                            <select class="form-control selectpicker" wire:model.live="range_from_iccid" data-live-search="true">
                                <option value="null">Please Select</option>
                                @foreach($sims as $sim)
                                    <option value="{{$sim['serial_no']}}">{{$sim['serial_no']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div wire:ignore class="col-lg-6">
                            <select class="form-control selectpicker" wire:model.live="range_to_iccid" data-live-search="true">
                                <option value="null">Please Select</option>
                                @foreach($sims as $sim)
                                    <option value="{{$sim['serial_no']}}">{{$sim['serial_no']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @if ($range_to_iccid && $range_from_iccid && $range_to_iccid !== 'null' && $range_from_iccid !== 'null')
                    @if ($range_from_iccid > $range_to_iccid)
                        <div class="col-xl-3">
                            The first entry must be smaller than the second entry.
                        </div>
                    @else
                        <div class="col-xl-3">
                            Potential Amount of sims being activated <span class="pl-1">{{($range_to_iccid - $range_from_iccid) + 1}}</span>
                        </div>
                    @endif
                @endif
            </div>
            @if (count($failed))
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">Failed On Delete</label>
                    <div class="col-lg-9 col-xl-6">
                        @foreach($failed as $item)
                            <div class="p-2 text-danger">{{$item}}</div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="d-flex justify-content-end w-100">
            <button onclick="areYouSure()" class="btn btn-success">Deactivate</button>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function areYouSure() {
            Swal.fire({
                title: "Are you sure?",
                text: "This will remove the sim from the portal and from bics.",
                icon: "warning",
                showCancelButton: true,
                dangerMode: true,
            }).then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        Livewire.dispatch('delete')
                    }
                });
        }
    </script>
    <script>
        window.addEventListener('deleteSuccess', failed => {
            Swal.fire(
                'Endpoints Deleted',
                'The sim/sims have been de-activated and re-added to sim pool.',
                'success'
            )
        });
        window.addEventListener('simRangeError', () => {
            Swal.fire(
                'Sim Range Error',
                'The first entry of the sim range must be smaller than the second entry.',
                'error'
            )
        });
    </script>
@endpush
