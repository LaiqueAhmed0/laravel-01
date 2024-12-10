@extends('layouts.layout')

@push('content')
    <div class="row">

        <div class="col-xl-12">
            <x-dashboard.sim.selection :sims="$sims"></x-dashboard.sim.selection>
        </div>
        
    </div>
@endpush

@push('scripts')


    <script>

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
        });

        $('#simDelete').click(function (e) {
            e.preventDefault();
            var link = $(this).attr('href');

            swalWithBootstrapButtons.fire({
                title: 'Are you sure you want to remove the current sim?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.value) {
                    window.location.href = link;
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {

                }
            });

        });


        $('#simSelect').change(function () {
            var urlParams = parseURLParams(window.location.href);
            if (urlParams && urlParams['to']) {
                window.location.href = "/dashboard?sim=" + $(this).val() + '&to=' + urlParams['to'];
            } else {
                window.location.href = "/dashboard?sim=" + $(this).val();
            }
        });

        function parseURLParams(url) {
            var queryStart = url.indexOf("?") + 1,
                queryEnd = url.indexOf("#") + 1 || url.length + 1,
                query = url.slice(queryStart, queryEnd - 1),
                pairs = query.replace(/\+/g, " ").split("&"),
                parms = {}, i, n, v, nv;

            if (query === url || query === "") return;

            for (i = 0; i < pairs.length; i++) {
                nv = pairs[i].split("=", 2);
                n = decodeURIComponent(nv[0]);
                v = decodeURIComponent(nv[1]);

                if (!parms.hasOwnProperty(n)) parms[n] = [];
                parms[n].push(nv.length === 2 ? v : null);
            }
            return parms;
        }

    </script>

@endpush
