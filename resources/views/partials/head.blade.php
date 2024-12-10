<!-- begin::Head -->
	<head>

		<!--begin::Base Path (base relative path for assets of this page) -->
		<base href="../">

		<!--end::Base Path -->
		<meta charset="utf-8" />
		<title>Mobile Data Top up | {!! !empty($subHeader) ? $subHeader : 'N/A' !!}</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!--begin::Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">

		<!--end::Fonts -->

        @stack('head')

		<!--begin:: Global Optional Vendors -->
		<link href="/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />

		<!--end:: Global Optional Vendors -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="/css/style.bundle.css" rel="stylesheet" type="text/css" />

		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins(used by all pages) -->

		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="/media/favicon-square.png" />
		<link href="{{ asset('css/custom.css') }}" rel="stylesheet">

		@vite('resources/src/app.ts')
		@livewireStyles
	</head>

<!-- end::Head -->
