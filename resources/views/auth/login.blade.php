<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->
<head>
    <base href="/">
    <meta charset="utf-8"/>
    <title>Mobile Data Top Up | Login</title>
    <meta name="description" content="Login page example"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="/css/pages/login/login-2.css" rel="stylesheet" type="text/css"/>
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="/css/style.bundle.css" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="/media/favicon-square.png"/>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" style="background-image: url(/media/bg/bg-10.jpg)" class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
            <!--begin: Aside Container-->
            <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
                <!--begin::Logo-->
                <a href="https://lovemobiledata.com/" class="text-center pt-2">
                    <img src="/media/lmd.svg" class="max-h-75px" alt=""/>
                </a>
                <!--end::Logo-->
                <!--begin::Aside body-->
                <div class="d-flex flex-column-fluid flex-column flex-center">
                    <!--begin::Signin-->
                    <div class="login-form login-signin py-11">
                        <!--begin::Form-->
                        <form class="form" novalidate="novalidate" action="{{route('login')}}" method="post" id="kt_login_signin_form">
                            @csrf
                            <!--begin::Title-->
                            <div class="text-center pb-8">
                                <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">{{isset($_GET['retailer']) ? 'Partner ' : ''}}Sign In</h2>
                                <span class="text-muted font-weight-bold font-size-h4">Or
                                    @if (isset($_GET['retailer']))
                                        <a href="https://lovemobiledata.com/#partner" class="text-primary font-weight-bolder">Contact Us To Become a Partner</a>
                                    @else
                                        <a href="/register" class="text-primary font-weight-bolder">Create an account to register, view usage and top up your SIM</a>
                                    @endif
                                </span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg @error('email') is-invalid @enderror " type="text" name="email" autocomplete="off" value="{{old('email')}}"/>
                                @error('email')
                                <div class="invalid-feedback d-block">{{$message}}</div>
                                @enderror
                            </div>
                            <!--end::Form group-->
                            <!--begin::Form group-->
                            <div class="form-group">
                                <div class="d-flex justify-content-between mt-n5">
                                    <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                                    <a href="/password/reset" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">Forgot
                                        Password ?</a>
                                </div>
                                <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg @error('password') is-invalid @enderror " type="password" name="password" autocomplete="off"/>
                                @error('password')
                                <div class="invalid-feedback d-block">{{$message}}</div>
                                @enderror
                            </div>
                            <!--end::Form group-->
                            <!--begin::Action-->
                            <div class="text-center pt-2">
                                <button id="kt_login_signin_submit" type="submit" class="btn btn-dark font-weight-bolder font-size-h6 px-8 py-4 my-3" style="background-color: #fe328d;border-color: #fe328d">
                                    Sign In
                                </button>
                            </div>
                            <!--end::Action-->

                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Signin-->
                </div>
                <!--end::Aside body-->
            </div>
            <!--end: Aside Container-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0" style="background: rgb(255,48,143);background: linear-gradient(127deg, rgba(255,48,143,1) 0%, rgba(246,146,66,1) 100%);">
            <!--begin::Title-->
            <div class="d-flex flex-column justify-content-center text-center pt-lg-40 pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7">
                <h3 class="display4 font-weight-bolder my-7 text-light" style="color: #986923;">Love Mobile Data</h3>
                <p class="font-weight-bolder font-size-h2-md font-size-lg text-light opacity-70 text-capitalize">Take control over your mobile data &
                    <br/>start loving the data freedom</p>
            </div>
            <!--end::Title-->
            <!--begin::Image-->
            <div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url(/media/svg/illustrations/login-visual-2.svg);"></div>
            <!--end::Image-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->
<script>var HOST_URL = "https://mobile.eagle.brd.ltd/";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = {
        "breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#6993FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1E9FF",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="/plugins/global/plugins.bundle.js"></script>
<script src="/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="/js/scripts.bundle.js"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Scripts(used by this page)-->
<script src="/js/pages/custom/login/login-general.js"></script>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
