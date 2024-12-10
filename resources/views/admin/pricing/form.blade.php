@extends('layouts.layout')

@push('content')
    <div class="row">
        <div class="col-sm-8 offset-2">
            <livewire:pricing-form
                    :pricing="$pricing ?? null"
            ></livewire:pricing-form>
        </div>
    </div>
    @push('scripts')
        <script>
            $('#submitBtn').on('click', function () {
                const countriesInput = $('[name="countries[]"]');
                let countiesString = '';
                for (let country of countriesInput.val()) {
                    countiesString += '<li>'+countriesInput.children(`option[value="${country}"]`).html()+'</li>';
                }
                countiesString = countiesString.slice(0, -2)

                Swal.fire({
                    title: 'Confirm countries',
                    html: `You have selected the following countries: <ol class="text-left max-h-100px overflow-auto">${countiesString}</ol>`,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#1e2252',
                    cancelButtonColor: '#ff308f',
                    confirmButtonText: `Confirm`,
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    //if user clicks on delete
                    if (result.value) {

                        $('form#planCreate').submit();
                    } else {
                        // responseAlert({
                        //     title: 'Operation Cancelled!',
                        //     type: 'success'
                        // });
                    }
                });
            });
        </script>

    @endpush

@endpush