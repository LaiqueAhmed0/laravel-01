<div>
    <x-loader id="loader" wire:loading/>
    <div class="row">
        <div class="col-8">
            <div class="form-group row">
                <label class="col-xl-3 col-lg-3 col-form-label">Add Plan <span class="text-danger">*</span></label>
                <div wire:ignore class="col-lg-9 col-xl-9">
                    <select class="form-control selectpicker" id="add-plan" data-live-search="true" wire:model.live="plan">
                        <option value="null">Please Select</option>
                        @foreach($plans as $plan)
                            <option value="{{$plan->id}}">{{$plan->name}} - {{$plan->length}} days</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end align-items-center w-100">
            <button onclick="areYouSureAddBenefit()" class="btn btn-success" wire:loading.attr="disabled">Add</button>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function areYouSureAddBenefit() {
            Swal.fire({
                title: "Are you sure?",
                text: "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
                if (willDelete.isConfirmed) {
                    Livewire.dispatch('add')
                } else {

                }
            });
        }
    </script>
    <script>
        window.addEventListener('createSuccess', () => {
            Swal.fire(
                'Plan Added',
                'The plan has been added to the endpoint.',
                'success'
            )
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#add-plan').on('change', function (e) {
                var data = $('#add-plan').val();
                @this.set('plan', data);
            });
        });
    </script>
@endpush
