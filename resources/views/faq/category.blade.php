@extends('layouts.main')

@section('main')
	<!-- Page Header Start -->
	<section class="m-t-80 back-gradient p-t-40 p-b-40">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="input-buttons success m-b-40">
						<input type="text" placeholder="Ask a question">
						<button><i class="fa fa-search"></i></button>
					</div>
				</div>
				<div class="col-lg-12">
					<ol class="breadcrumb center-center">
						<li class="breadcrumb-item"><a href="#">Help Center</a></li>
                        <li class="breadcrumb-item" aria-current="page">Getting Started</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ucfirst($category->name)}}</li>
					</ol>
                </div>
			</div>
		</div>
	</section>
	<!-- Page Header End -->

	<!-- Topics Start -->
	<section class="p-t-60 p-b-60">
		<div class="container">
			<div class="row text-center">
				<div class="offset-lg-3 col-lg-6">
					<div class="header-badge m-b-15">Topics</div>
					<h2 class="m-b-10">Explore Topics</h2>
					<p class="m-b-40">Fusce placerat pretium mauris, vel sollicitudin elit lacinia vitae. Quisque sit amet nisi erat.</p>
				</div>
			</div>
			<div class="row" id="accordion" >
				<div class="col-lg-4 m-b-30">
					<div class="d-flex align-items-center m-b-20">
						<div class="badge-circle primary m-r-10">19</div>
						<h5 class="flex-1">Introduction</h5>
                    </div>
					<ul class="list-unstyled">
						<li class="m-b-10">
                            <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-1" aria-expanded="false" aria-controls="article-1">
                                    <i class="fa fa-file-o m-r-15"></i>
                                    Button with data-target
                            </button>
                            <div class="collapse" id="article-1" data-parent="#accordion">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                    <br><a href="">Meer info</a>
                                </div>
                            </div>
						</li>
						<li class="m-b-10">
                            <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-2" aria-expanded="false" aria-controls="article-2">
                                    <i class="fa fa-file-o m-r-15"></i>
                                    Button with data-target
                            </button>
                            <div class="collapse" id="article-2" data-parent="#accordion">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                    <br><a href="">Meer info</a>
                                </div>
                            </div>
						</li>
						<li class="m-b-10">
                            <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-3" aria-expanded="false" aria-controls="article-3">
                                    <i class="fa fa-file-o m-r-15"></i>
                                    Button with data-target
                            </button>
                            <div class="collapse" id="article-3" data-parent="#accordion">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                    <br><a href="">Meer info</a>
                                </div>
                            </div>
						</li>
						<li class="m-b-10">
                            <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-4" aria-expanded="false" aria-controls="article-4">
                                    <i class="fa fa-file-o m-r-15"></i>
                                    Button with data-target
                            </button>
                            <div class="collapse" id="article-4" data-parent="#accordion">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                    <br><a href="">Meer info</a>
                                </div>
                            </div>
						</li>
						<li class="m-b-10">
                            <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-5" aria-expanded="false" aria-controls="article-5">
                                    <i class="fa fa-file-o m-r-15"></i>
                                    Button with data-target
                            </button>
                            <div class="collapse" id="article-5" data-parent="#accordion">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                    <br><a href="">Meer info</a>
                                </div>
                            </div>
						</li>
					</ul>
				</div>
				<div class="col-lg-4 m-b-30">
					<div class="d-flex align-items-center m-b-20">
						<div class="badge-circle primary m-r-10">23</div>
						<h5 class="flex-1">Account</h5>
					</div>
                    <ul class="list-unstyled">
                        <li class="m-b-10">
                            <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-6" aria-expanded="false" aria-controls="article-6">
                                    <i class="fa fa-file-o m-r-15"></i>
                                    Button with data-target
                            </button>
                            <div class="collapse" id="article-6" data-parent="#accordion">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                    <br><a href="">Meer info</a>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-10">
                            <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-7" aria-expanded="false" aria-controls="article-7">
                                    <i class="fa fa-file-o m-r-15"></i>
                                    Button with data-target
                            </button>
                            <div class="collapse" id="article-7" data-parent="#accordion">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                    <br><a href="">Meer info</a>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-10">
                            <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-8" aria-expanded="false" aria-controls="article-8">
                                    <i class="fa fa-file-o m-r-15"></i>
                                    Button with data-target
                            </button>
                            <div class="collapse" id="article-8" data-parent="#accordion">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                    <br><a href="">Meer info</a>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-10">
                            <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-9" aria-expanded="false" aria-controls="article-9">
                                    <i class="fa fa-file-o m-r-15"></i>
                                    Button with data-target
                            </button>
                            <div class="collapse" id="article-9" data-parent="#accordion">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                    <br><a href="">Meer info</a>
                                </div>
                            </div>
                        </li>
                        <li class="m-b-10">
                            <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-10" aria-expanded="false" aria-controls="article-10">
                                    <i class="fa fa-file-o m-r-15"></i>
                                    Button with data-target
                            </button>
                            <div class="collapse" id="article-10" data-parent="#accordion">
                                <div class="card card-body">
                                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                    <br><a href="">Meer info</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 m-b-30">
                        <div class="d-flex align-items-center m-b-20">
                            <div class="badge-circle primary m-r-10">23</div>
                            <h5 class="flex-1">Account</h5>
                        </div>
                        <ul class="list-unstyled">
                            <li class="m-b-10">
                                <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-11" aria-expanded="false" aria-controls="article-11">
                                        <i class="fa fa-file-o m-r-15"></i>
                                        Button with data-target
                                </button>
                                <div class="collapse" id="article-11" data-parent="#accordion">
                                    <div class="card card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                        <br><a href="">Meer info</a>
                                    </div>
                                </div>
                            </li>
                            <li class="m-b-10">
                                <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-12" aria-expanded="false" aria-controls="article-12">
                                        <i class="fa fa-file-o m-r-15"></i>
                                        Button with data-target
                                </button>
                                <div class="collapse" id="article-12" data-parent="#accordion">
                                    <div class="card card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                        <br><a href="">Meer info</a>
                                    </div>
                                </div>
                            </li>
                            <li class="m-b-10">
                                <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-13" aria-expanded="false" aria-controls="article-13">
                                        <i class="fa fa-file-o m-r-15"></i>
                                        Button with data-target
                                </button>
                                <div class="collapse" id="article-13" data-parent="#accordion">
                                    <div class="card card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                        <br><a href="">Meer info</a>
                                    </div>
                                </div>
                            </li>
                            <li class="m-b-10">
                                <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-14" aria-expanded="false" aria-controls="article-14">
                                        <i class="fa fa-file-o m-r-15"></i>
                                        Button with data-target
                                </button>
                                <div class="collapse" id="article-14" data-parent="#accordion">
                                    <div class="card card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                        <br><a href="">Meer info</a>
                                    </div>
                                </div>
                            </li>
                            <li class="m-b-10">
                                <button class="button-text text-color-reset" type="text" data-toggle="collapse" data-target="#article-15" aria-expanded="false" aria-controls="article-15">
                                        <i class="fa fa-file-o m-r-15"></i>
                                        Button with data-target
                                </button>
                                <div class="collapse" id="article-15" data-parent="#accordion">
                                    <div class="card card-body">
                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                                        <br><a href="">Meer info</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
			</div>
		</div>
	</section>
	<!-- Topics End -->

@endsection