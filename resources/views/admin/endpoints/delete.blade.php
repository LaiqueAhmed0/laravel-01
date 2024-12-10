@extends('layouts.layout', ['subHeader' => 'Activate Sim', 'back'=> '/admin/endpoints'])

@push('content')

    <div class="card card-custom">
        <div class="card-header py-5 border-bottom-0">
            <div class="card-label">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark">Sims Deactivation</span>
                    <span class="text-muted mt-3 font-weight-bold font-size-sm">Deactivate sim</span>
                </h3>
            </div>
            <div class="card-toolbar">
                <div class="input-icon">

                </div>
            </div>
        </div>

        <div class="card-body ">
            <livewire:endpoint-delete></livewire:endpoint-delete>
        </div>
    </div>
@endpush