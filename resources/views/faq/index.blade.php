@extends('layouts.main')

@section('includesheader')
<link href="assets/fontawesome-free-5.13.0-web/css/all.css" rel="stylesheet" type="text/css">
@endsection

@section('main')

	<!-- Welcome Start -->
	<section class="p-t-120 p-b-120 m-t-80 section-blue position-relative">
		<div class="position-absolute top-0 left-0">
			<img src="../assets/images/welcome/7.svg" alt="">
		</div>
		<div class="position-absolute bottom-0 right-0">
			<img src="../assets/images/welcome/7.svg" alt="">
		</div>
		<div class="container">
			<div class="row">
				<div class="offset-lg-3 col-lg-6 text-center">
					<h1 class="m-b-40">How can we help?</h1>
					<div class="input-buttons primary gradient m-b-30">
						<input type="text" placeholder="Ask a question">
						<button><i class="fa fa-search"></i></button>
					</div>
					<p>Popular help topics: <a class="link-text m-l-5" href="#">account,</a> <a class="link-text m-l-5" href="#">pricing,</a> <a class="link-text m-l-5" href="#">payment,</a> <a class="link-text m-l-5" href="#">update</a></p>
				</div>
			</div>
		</div>
	</section>
	<!-- Welcome End -->


	<!-- Page Content Start -->
	<section class="p-t-120 p-b-90">
		<div class="container">
			<div class="row">
				<!-- item start -->
				<div class="col-lg-6" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.1s">
					<a href="#" class="box rounded p-25 d-flex align-items-center m-b-30 transition-3d-hover link-text-d-n">
						<div class="icon m-r-20">
							<img src="../assets/images/photos/icons/help/1.png" alt="">
						</div>
						<div class="text">
							<h5 class="m-b-10">Getting Started</h5>
							<p>Quisque at arcu at turpis lobortis ultrices. Nullam et accumsan.</p>
						</div>
					</a>
				</div>
				<!-- item end -->

				<!-- item start -->
				<div class="col-lg-6" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.2s">
					<a href="#" class="box rounded p-25 d-flex align-items-center m-b-30 transition-3d-hover link-text-d-n">
						<div class="icon m-r-20">
							<img src="../assets/images/photos/icons/help/2.png" alt="">
						</div>
						<div class="text">
							<h5 class="m-b-10">Account</h5>
							<p>Donec eu eros vulputate, laoreet tellus non, porttitor libero fusce.</p>
						</div>
					</a>
				</div>
				<!-- item end -->

				<!-- item start -->
				<div class="col-lg-6" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.3s">
					<a href="#" class="box rounded p-25 d-flex align-items-center m-b-30 transition-3d-hover link-text-d-n">
						<div class="icon m-r-20">
							<img src="../assets/images/photos/icons/help/3.png" alt="">
						</div>
						<div class="text">
							<h5 class="m-b-10">Data Security</h5>
							<p>Mauris eget eleifend massa. Nunc suscipit tortor a dui condiment.</p>
						</div>
					</a>
				</div>
				<!-- item end -->

				<!-- item start -->
				<div class="col-lg-6" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.4s">
					<a href="#" class="box rounded p-25 d-flex align-items-center m-b-30 transition-3d-hover link-text-d-n">
						<div class="icon m-r-20">
							<img src="../assets/images/photos/icons/help/4.png" alt="">
						</div>
						<div class="text">
							<h5 class="m-b-10">Market</h5>
							<p>Sed eget velit vitae dolor dignissim feugiat. Cras quis felis nec.</p>
						</div>
					</a>
				</div>
				<!-- item end -->

				<!-- item start -->
				<div class="col-lg-6" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.5s">
					<a href="#" class="box rounded p-25 d-flex align-items-center m-b-30 transition-3d-hover link-text-d-n">
						<div class="icon m-r-20">
							<img src="../assets/images/photos/icons/help/5.png" alt="">
						</div>
						<div class="text">
							<h5 class="m-b-10">Subscription</h5>
							<p>Phasellus suscipit varius ligula, sit amet dictum dui luctus eget.</p>
						</div>
					</a>
				</div>
				<!-- item end -->

				<!-- item start -->
				<div class="col-lg-6" data-scroll-reveal="enter bottom move 50px over 0.6s after 0.6s">
					<a href="#" class="box rounded p-25 d-flex align-items-center m-b-30 transition-3d-hover link-text-d-n">
						<div class="icon m-r-20">
							<img src="../assets/images/photos/icons/help/6.png" alt="">
						</div>
						<div class="text">
							<h5 class="m-b-10">Tips, Tricks & More</h5>
							<p>Morbi sed imperdiet dui. Phasellus aliquet risus ligula, nec element.</p>
						</div>
					</a>
				</div>
				<!-- item end -->
			</div>
		</div>
	</section>
	<!-- Page Content End -->


	<!-- Footer Section Start -->
	<section class="p-t-120 p-b-120 section-blue border-bottom">
		<div class="container">
			<div class="row">
				<div class="offset-lg-3 col-lg-6 text-center">
					<h2 class="m-b-10">Still no luck? We can help!</h2>
					<p class="m-b-40">Fusce placerat pretium mauris, vel sollicitudin elit lacinia vitae. Quisque sit amet nisi erat.</p>
					<a href="#" class="button button-primary transition-3d-hover">Submit a Request</a>
				</div>
			</div>
		</div>
	</section>
	<!-- Footer Section End -->
	
	
@endsection