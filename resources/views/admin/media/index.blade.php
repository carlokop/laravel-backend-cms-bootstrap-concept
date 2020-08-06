@extends('layouts.admin')
@php 
    $title = "Media gellery";
    $cats = [""];
@endphp

@section('css')
    <link rel="stylesheet" href="{{asset('administrator/assets/vendor/dropzone/dropzone.min.css')}}">
@endsection

@section('main')
    <div class="row">
        <div class="col-12 mb-3">
              {!! Form::open(['method' => 'post', 'routes' => 'admin.media.store', 'files' => true, 'class' => 'dropzone', 'id'=> 'dropzone']) !!}
              <div class="fallback">
                {!! Form::file('file',['multiple']); !!}
                {!! Form::submit(); !!}
              </div>
              @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif
              {!! Form::close() !!}
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-10 col-xl-9 col-lg-8 col-md-8 col-sm-12 col-12">
            <div class="row" id="gallery">
                @foreach($images as $image)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-12">
                        <div class="card card-figure">
                            <!-- .card-figure -->
                            <figure class="figure">
                                <!-- .figure-img -->
                                <div class="figure-img">
                                    @php
                                        $imagefile = $image->imagefiles[(count($image->imagefiles)-1)];
                                        $resolution = json_decode($image->imagefiles[0]->resolution);
                                    @endphp
                                    <img class="img-fluid card-img" src="{{asset($imagefile->path)}}" alt="{{$image->alt}}" title="{{$image->title}}">

                                    <div class="figure-description">
                                    <h6 class="figure-title"> {{$image->name}} </h6>
                                    <p class="text-muted mb-0">
                                        <small>{{$image->title}}</small>
                                    </p>
                                    </div>
                                    <div class="figure-tools">
                                        <a href="#" class="tile tile-circle tile-sm mr-auto">   </a>
                                        <p class="badge badge-light">{{$resolution->width}} x {{$resolution->height}}px</p>
                                        <p class="badge badge-secondary">{{$imagefile->file_type}}</p>
                                    </div>
                                    <div class="figure-action">
                                        <a href="{{route('admin.media.show', ['id' => $image->id])}}" class="btn btn-block btn-sm btn-primary">Open</a>
                                    </div>
                                </div>
                                <!-- /.figure-img -->
                            </figure>
                            <!-- /.card-figure -->
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-xxl-2 col-xl-3 col-lg-2 col-md-4 col-sm-12 col-12">
            
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('administrator/assets/vendor/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('administrator/assets/js/custom-es5-backend.js')}}"></script>
    <script>

        Dropzone.options.dropzone = {
            init: function() {
                this.on("complete", function(file) {
                    var gallery = document.querySelector('#gallery');
                    fetch('{{asset('/api/media/upload/')}}').then(function (response) {
                        return response.json();
                    }) 
                    .then(function (data) {
                        gallery.innerHTML += templateAddMediaToGallery(data);
                    });
                });
            }
        };

    </script>
@endsection
