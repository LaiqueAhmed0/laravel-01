<div>
    <x-loader id="loader" wire:loading/>
    <div class="row">
        <div class="col-12">
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Remove Plan <span class="text-danger">*</span></label>
                <div class="col-lg-9 col-xl-6">
                    <select class="form-control" wire:model.live="benefit">
                        <option value="null">Please Select</option>
                        @if ($sim?->current_endpoint)
                            @foreach($sim->current_endpoint->benefits_from_bics_formatted as $benefit)
                                <option value="{{$benefit->id}}">{{$benefit->plan->name ?? 'Not Found Plan'}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end align-items-center w-100">
            <button onclick="areYouSureRemoveBenefit()" class="btn btn-success" wire:loading.attr="disabled">Remove</button>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function areYouSureRemoveBenefit() {
            Swal.fire({
                title: "Are you sure?",
                text: "",
                icon: "warning",
                showCancelButton: true,
                dangerMode: true,
            }).then((willDelete) => {
                // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
                if (willDelete.isConfirmed) {
                    Livewire.dispatch('remove')
                } else {

                }
            });
        }
    </script>
    <script>
        window.addEventListener('removeSuccess', () => {
            Swal.fire(
                'Plan Removed',
                'The plan has been added to the endpoint.',
                'success'
            )
        });
    </script>
@endpush
