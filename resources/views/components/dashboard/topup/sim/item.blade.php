<tr class=" px-6">
    <td class="py-6 pl-0">
        <a href="/dashboard/{{$item->iccid}}"
           class="text-dark font-weight-bolder text-hover-primary mb-1 font-size-lg">{{$item->iccid}}</a>
        <span class="text-muted font-weight-bold d-block">Iccid</span>
    </td>
    <td>
        <div class="d-flex flex-column w-100 mr-2">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted mr-2 font-size-sm font-weight-bold">{{$item->getUsagePercentage()}}%</span>
                <span class="text-muted font-size-sm font-weight-bold">Usage</span>
            </div>
            <div class="progress progress-xs w-100">
                <div class="progress-bar bg-brand" role="progressbar"
                     style="width: {{$item->getUsagePercentage()}}%;"
                     aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </td>
    <td class="text-right pr-0">
        @if ($endpoint->iccid == $item->iccid)
            <button class="btn btn-icon btn-light btn-sm">
                <span class="svg-icon svg-icon-md svg-icon-success">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                         height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none"
                       fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"/>
                        <path d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z"
                              fill="#000000" fill-rule="nonzero"
                              transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002) "/>
                    </g>
                    </svg><!--end::Svg Icon-->
                </span>
            </button>
        @else
            <a href="/top-ups/{{$item->iccid}}"
               class="btn btn-icon btn-light btn-sm" data-toggle="tooltip" data-theme="dark" title="Topup">
                <span class="svg-icon svg-icon-md svg-icon-success">
                   <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Angle-double-up.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"/>
                            <path d="M8.2928955,10.2071068 C7.90237121,9.81658249 7.90237121,9.18341751 8.2928955,8.79289322 C8.6834198,8.40236893 9.31658478,8.40236893 9.70710907,8.79289322 L15.7071091,14.7928932 C16.085688,15.1714722 16.0989336,15.7810586 15.7371564,16.1757246 L10.2371564,22.1757246 C9.86396402,22.5828436 9.23139665,22.6103465 8.82427766,22.2371541 C8.41715867,21.8639617 8.38965574,21.2313944 8.76284815,20.8242754 L13.6158645,15.5300757 L8.2928955,10.2071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 15.500003) scale(-1, 1) rotate(-90.000000) translate(-12.000003, -15.500003) "/>
                            <path d="M6.70710678,12.2071104 C6.31658249,12.5976347 5.68341751,12.5976347 5.29289322,12.2071104 C4.90236893,11.8165861 4.90236893,11.1834211 5.29289322,10.7928968 L11.2928932,4.79289682 C11.6714722,4.41431789 12.2810586,4.40107226 12.6757246,4.76284946 L18.6757246,10.2628495 C19.0828436,10.6360419 19.1103465,11.2686092 18.7371541,11.6757282 C18.3639617,12.0828472 17.7313944,12.1103502 17.3242754,11.7371577 L12.0300757,6.88414142 L6.70710678,12.2071104 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(12.000003, 8.500003) scale(-1, 1) rotate(-360.000000) translate(-12.000003, -8.500003) "/>
                        </g>
                    </svg><!--end::Svg Icon-->
                </span>
            </a>
        @endif
    </td>
</tr>