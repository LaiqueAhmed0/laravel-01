<!--begin::Aside-->
<div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
    <!--begin::Profile Card-->
    <div class="card card-custom card-stretch">
        <!--begin::Body-->
        <div class="card-body pt-8">

            <!--begin::User-->
            <div class="d-flex align-items-center">
                <div class="symbol symbol-light-success symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                    <span class="symbol-label font-size-h2 font-weight-bold">{{substr ($user->first_name, 0, 1)}}{{substr ($user->last_name, 0, 1)}}</span>
                </div>
                <div>
                    <a href="#"
                       class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{$user->first_name}} {{$user->last_name}}</a>
                    <div class="text-muted">{{$user->group == 1 ? 'Customer' : 'Retailer'}}</div>
                </div>
            </div>
            <!--end::User-->
            <!--begin::Contact-->
            <div class="py-9">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="font-weight-bold mr-2">Email:</span>
                    <a href="#" class="text-muted text-hover-primary">{{$user->email}}</a>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="font-weight-bold mr-2">Phone:</span>
                    <span class="text-muted">{{$user->phone}}</span>
                </div>
            </div>
            <!--end::Contact-->
            <!--begin::Nav-->
            <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                <div class="navi-item mb-2">
                    <a href="/profile/personal-information" class="navi-link py-4">
						<span class="navi-icon mr-2">
							<span class="svg-icon">
								<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
								<svg xmlns="http://www.w3.org/2000/svg"
									 xmlns:xlink="http://www.w3.org/1999/xlink"
									 width="24px" height="24px" viewBox="0 0 24 24"
									 version="1.1">
									<g stroke="none" stroke-width="1" fill="none"
									   fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24"/>
										<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
											  fill="#000000" fill-rule="nonzero"
											  opacity="0.3"/>
										<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
											  fill="#000000" fill-rule="nonzero"/>
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
						</span>
                        <span class="navi-text font-size-lg">Personal Information</span>
                    </a>
                </div>
                <div class="navi-item mb-2">
                    <a href="/profile/change-password" class="navi-link py-4">
						<span class="navi-icon mr-2">
							<span class="svg-icon">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Shield-user.svg-->
								<svg xmlns="http://www.w3.org/2000/svg"
									 xmlns:xlink="http://www.w3.org/1999/xlink"
									 width="24px" height="24px" viewBox="0 0 24 24"
									 version="1.1">
									<g stroke="none" stroke-width="1" fill="none"
									   fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
											  fill="#000000" opacity="0.3"/>
										<path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z"
											  fill="#000000" opacity="0.3"/>
										<path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z"
											  fill="#000000" opacity="0.3"/>
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
						</span>
						<span class="navi-text font-size-lg">Change Password</span>
                    </a>
                </div>
                <div class="navi-item mb-2">
                    <a href="/profile/notifications" class="navi-link py-4">
						<span class="navi-icon mr-2">
							<span class="svg-icon">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
								<svg xmlns="http://www.w3.org/2000/svg"
									 xmlns:xlink="http://www.w3.org/1999/xlink"
									 width="24px" height="24px" viewBox="0 0 24 24"
									 version="1.1">
									<g stroke="none" stroke-width="1" fill="none"
									   fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"/>
										<path d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z"
											  fill="#000000" opacity="0.3"/>
										<path d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z"
											  fill="#000000"/>
									</g>
								</svg>
								<!--end::Svg Icon-->
							</span>
						</span>
                        <span class="navi-text font-size-lg">Email settings</span>
                    </a>
                </div>
            </div>
            <!--end::Nav-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Profile Card-->
</div>
<!--end::Aside-->


