@extends('layouts.layout')

@push('content')
    <!--Begin::Section-->
    <div class="row">
        <div class="offset-xl-4 col-xl-4 ">
            <div class="row row-full-height">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">
                                    Register Your Sim
                                </h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="/dashboard"><i class="la la-times icon-2x"></i> </a>
                            </div>

                        </div>
                        <form class="kt-form" method="POST" action="/sim/register">
                            <div class="card-body">
                                @csrf
                                <div class="form-group">
                                    <label>Sim ICCID (Example: 893204 2000000123456 7)</label>
                                    <div class="d-flex" style="gap: 4px">
                                        <input class="form-control form-control-lg form-control-solid text-center w-120px" name="iccid_first" maxlength="6" placeholder="893204" required>
                                        <input class="form-control form-control-lg form-control-solid text-center" name="iccid_end" maxlength="13" placeholder="2000000123456" required>
                                        <input class="form-control form-control-lg form-control-solid text-center w-50px" name="iccid_luhn" maxlength="1" placeholder="7" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Sim ICCID</label>
                                    <div class="d-flex" style="gap: 4px">
                                        <input class="form-control form-control-lg form-control-solid text-center w-120px" name="iccid_first_confirmation" maxlength="6" placeholder="893204" required>
                                        <input class="form-control form-control-lg form-control-solid text-center" name="iccid_end_confirmation" maxlength="13" placeholder="2000000123456" required>
                                        <input class="form-control form-control-lg form-control-solid text-center w-50px" name="iccid_luhn_confirmation" maxlength="1" placeholder="7" required>
                                    </div>
                                </div>
                                @if ($errors->any())
                                    <div class="invalid-feedback" style="display: block;font-size: 14px; font-weight: 400;">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}<br>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::Section-->
@endpush

@push('scripts')

    <script>

        window.onload = () => {
            let myInput = document.querySelector('[name="iccid_first_confirmation"]');
            myInput.onpaste = e => e.preventDefault();
            myInput = document.querySelector('[name="iccid_end_confirmation"]');
            myInput.onpaste = e => e.preventDefault();
            myInput = document.querySelector('[name="iccid_first"]');
            myInput.onpaste = e => e.preventDefault();
            myInput = document.querySelector('[name="iccid_end"]');
            myInput.onpaste = e => e.preventDefault();
        }

        document.querySelector('.kt-form').addEventListener('submit', function (e) {
            var form = this;
            var iccid = $('[name="iccid_first"]').val() + $('[name="iccid_end"]').val();
            var iccidConfirmation = $('[name="iccid_first_confirmation"]').val() + $('[name="iccid_end_confirmation"]').val();

            if (iccid === '' || iccidConfirmation === '') {
                e.preventDefault();
            } else {
                e.preventDefault(); // <--- prevent form from submitting

                Swal.fire({
                    title: "Confirmation",
                    text: "You are about to register the following sim: " + iccid + ", is this correct?",
                    icon: "warning",
                    buttons: [
                        'No, reenter sim id!',
                        'Yes, this is correct!'
                    ],
                    dangerMode: true,
                }).then(function (isConfirm) {
                    if (isConfirm) {
                        form.submit();
                    } else {
                        iccid.val('');
                        iccidConfirmation.val('');
                    }
                })
            }
        });
    </script>

@endpush
