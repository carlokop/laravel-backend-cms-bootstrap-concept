@extends('layouts.main')

@section('includesheader')

@endsection

@section('main')


	<section class="p-t-120 p-b-120">
		<div class="container">
			<div class="row">
				<div class="offset-lg-1 col-lg-10">
					<div class="box rounded p-50">
						<h1 class="m-b-10">{{$post->title}}</h1>
						<p class="m-b-20">{{$post->intro}}</p>

						<!-- profile card start -->
						<div class="divider m-b-20"></div>
						<div class="d-flex align-items-center m-b-20">
							{{-- <div class="oval-70 overflow-hidden m-r-30">
								<img src="../assets/images/photos/profile/70/9.png" alt="">
							</div> --}}
							<div class="content w-100 flex-1">
								<div class="row d-flex align-items-center">
									<div class="col-lg-8">
										<div class="d-block">
											<span>Published by </span>
											<span class="text-color-heading">{{$post->user->name}}</span>
										</div>
										<span>Last update: {{$post->updated_at->diffForHumans()}}</span>
									</div>
									<div class="col-lg-4">
										<ul class="list-unstyled text-right sm-text-left">
											<li class="d-inline f-s-16 m-l-5 sm-m-0">
												<span>Share:</span>
											</li>
											<li class="d-inline f-s-16 m-l-5">
												<a class="text-color-reset" href="#"><i class="fa fa-twitter-square"></i></a>
											</li>
											<li class="d-inline f-s-16 m-l-5">
												<a class="text-color-reset" href="#"><i class="fa fa-linkedin-square"></i></a>
											</li>
											<li class="d-inline f-s-16 m-l-5">
												<a class="text-color-reset" href="#"><i class="fa fa-facebook-square"></i></a>
											</li>
											<li class="d-inline f-s-16 m-l-5">
												<a class="text-color-reset" href="#"><i class="fa fa-pinterest-square"></i></a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="divider m-b-20"></div>
						<!-- profile card end -->

						<div class="text-content pb-3">
							{{$post->content}}
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>

	@include('faq.partials._comments')

	

	
	
@endsection

@section('js')

	<script>
		commentFormReplyInit();

		//AJAX form handeling for already logged in user
		@if(Auth::user())

			var textarea = document.querySelector('#comment');
			$("#commentForm").submit(function(event){
				event.preventDefault();
				var values = $(this).serialize();
				$.ajax({
					header:{
						'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
					},
					url: "{{route('comments.store')}}",
					method: "POST",
					data: values,
					success: function (response) {
						response = JSON.parse(response);
						if(response.body) {
							var html = '<div class="alert alert-success alert-block">';
							html += '<button type="button" class="close" data-dismiss="alert">×</button>';	
							html += '<strong>Comment will be published after validation</strong>';
							html += '</div>';
							document.querySelector('#msgComment').innerHTML = html;
							textarea.value = null;
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
					console.error(textStatus, errorThrown);
					}
				});
			});
			
		@endif

	</script>

@endsection

