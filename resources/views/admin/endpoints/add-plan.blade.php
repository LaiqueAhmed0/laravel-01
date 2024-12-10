@extends('layouts.layout', ['subHeader' => 'Add/Remove Plan To Endpoint', 'back'=> '/admin/endpoints'])

@push('content')
    <x-loader id="loader" wire:loading/>

    <div class="row">
        <div class="col-6">
            <div class="card card-custom mb-10">
                <div class="card-header py-5 border-bottom-0">
                    <div class="card-label">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">Add Plan to {{$sim->iccid}}</span>
                            <span class="text-muted mt-3 font-weight-bold font-size-sm">Adding a plan to a sim</span>
                        </h3>
                    </div>
                </div>

                <div class="card-body ">
                    <livewire:endpoint-add-benefit :sim="$sim"></livewire:endpoint-add-benefit>
                </div>


            </div>
        </div>
        <div class="col-6">

            <div class="card card-custom">
                <div class="card-header py-5 border-bottom-0">
                    <div class="card-label">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label font-weight-bolder text-dark">Remove Plan From {{$sim->iccid}}</span>
                            <span class="text-muted mt-3 font-weight-bold font-size-sm">Removing a plan from a sim</span>
                        </h3>
                    </div>
                </div>

                <div class="card-body ">
                    <livewire:endpoint-remove-benefit :sim="$sim"></livewire:endpoint-remove-benefit>
                </div>


            </div>
        </div>
        @if($sim->user_id)
            <div class="col-6">
                <div class="card card-custom">
                    <div class="card-header py-5 border-bottom-0">
                        <div class="card-label">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Remove Claimant From {{$sim->iccid}}</span>
                                <span class="text-muted mt-3 font-weight-bold font-size-sm">Removing a claimant from a sim</span>
                            </h3>
                        </div>
                    </div>

                    <div class="card-body ">
                        <button id="claimant-btn" class="btn btn-danger" onClick="removeClaimant({{$sim->id}})">Remove Claimant</button>
                    </div>
                </div>
            </div>
        @endif

        @if($sim->retailer_id)
            <div class="col-6">
                <div class="card card-custom">
                    <div class="card-header py-5 border-bottom-0">
                        <div class="card-label">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Remove Retailer From {{$sim->iccid}}</span>
                                <span class="text-muted mt-3 font-weight-bold font-size-sm">Removing a retailer from a sim</span>
                            </h3>
                        </div>
                    </div>

                    <div class="card-body ">
                        <button id="retailer-btn" class="btn btn-danger" onClick="removeRetailer({{$sim->id}})">Remove Retailer</button>
                    </div>
                </div>
            </div>
        @endif
    </div>



@endpush

@push('scripts')
    <script>
        function removeClaimant(iccid) {
            $('#claimant-loader').removeClass('d-none');
            $('#claimant-btn').attr('disabled', true);
            Swal.fire({
                title: "Are you sure?",
                text: "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
                    $('#claimant-btn').attr('disabled', false);
                    if (willDelete.isConfirmed) {
                        window.location.href="/admin/sims/remove-claimant/"+iccid
                    } else {

                    }
                });
        }
        function removeRetailer(iccid) {
            $('#retailer-btn').attr('disabled', true);
            Swal.fire({
                title: "Are you sure?",
                text: "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    // redirect with javascript here as per your logic after showing the alert using the urlToRedirect value
                    $('#retailer-btn').attr('disabled', false);
                    if (willDelete.isConfirmed) {
                        window.location.href="/admin/sims/remove-retailer/"+iccid
                    } else {

                    }
                });
        }
    </script>
@endpush