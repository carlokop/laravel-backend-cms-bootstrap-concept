<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	@if(!empty($page))
	<title>{{$page->title}}</title>
	@elseif(!empty($faq))
	<title>{{$faq->title}}</title>
	@endif

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="assets/images/favicon/favicon.png" />
	<link href="{{asset('/assets/css/libs.css')}}" rel="stylesheet" type="text/css">
    @yield('includesheader')

	<!-- Custom CSS -->
	<link href="/assets/css/frontend.css" rel="stylesheet" type="text/css">
</head>
<body>


    @yield('main')

    	<!-- Footer Start -->
	<footer class="footer p-t-60">
	</footer>
	<!-- Footer End -->

	<script src="{{asset('assets/js/libs.js')}}"></script>
	<script src="{{asset('assets/js/custom-es5-frontend.js')}}"></script>
	@yield('js')
</body>
</html>