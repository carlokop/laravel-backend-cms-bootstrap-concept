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
        <div class="col-lg-7 col-md-6 col-sm-12 col-12">
            @php
                $imageLarge = $image->imagefiles[0];
                $res = json_decode($imageLarge->resolution);
            @endphp
            <img src="{{asset($imageLarge->path)}}" alt="" class="w-max-100">
            
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12 col-12">
            <div class="product-sidebar">
                <div class="product-sidebar-widget">
                    <h4 class="mb-0">Media attributes</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['method' => 'patch', 'route' => ['admin.media.update', $image->id]]) !!}
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        {!! Form::label('imageName', 'Image name'); !!}
                                        {!! Form::text('imageName', $image->name, ['class' => 'form-control']); !!}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        {!! Form::label('imageAlt', 'Alt text'); !!}
                                        {!! Form::text('imageAlt', $image->alt, ['class' => 'form-control']); !!}
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        {!! Form::label('imageTitle', 'Image name'); !!}
                                        {!! Form::text('imageTitle', $image->title, ['class' => 'form-control']); !!}
                                    </div>
                                </div>
                            </div>
                            {!! Form::submit('Updaten', ['class' => 'btn btn-primary']); !!}

                            <button type="button" name="imageDelete" class="btn btn-sm btn-outline imageDelete" data-imageid="{{$image->id}}"><i class="far fa-trash-alt"></i></button>
                            
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
                        <div class="modal" tabindex="-1" role="dialog" id="deleteImageModal-{{$image->id}}">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h3 class="modal-title">Delete image</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    <p class="alert alert-danger p-3" role="alert">You are at the point to delete {{$image->name}}. This cannot be restored.</p>
                                    </div>
                                    <div class="modal-footer">
                                        {!! Form::model($image, ['method' => 'DELETE', 'route' => ['admin.media.destroy',$image->id]]) !!}
                                        {!! Form::submit('Yes delete', ['class'=>'btn btn-primary']); !!}
                                        {!! Form::button('No', ['class'=>'btn btn-danger','data-dismiss'=>'modal']); !!}
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-sidebar mt-4">
                <div class="product-sidebar-widget">
                    <h4 class="mb-0">Media info</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row">File type</th>
                                    <td>{{$imageLarge->file_type}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">File size</th>
                                    <td>{{$imageLarge->get_units()}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Resolution</th>
                                    <td>{{$res->width}} x {{$res->height}}px</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="product-sidebar mt-4">
                <div class="product-sidebar-widget">
                    <h4 class="mb-0">Stored files</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">type</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Resolution</th>
                                    <th scope="col">Path</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($image->imagefiles as $imageVersion)
                                    @php
                                        $res = json_decode($imageVersion->resolution);
                                    @endphp
                                    <tr>
                                        <td>{{ucfirst($imageVersion->size_type)}}</td>
                                        <td>{{$imageVersion->get_units($imageVersion->size)}}</td>
                                        <td>{{$res->width}} x {{$res->height}}px</td>
                                        <td>{{asset($imageVersion->path)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('administrator/assets/vendor/dropzone/dropzone.min.js')}}"></script>
    <script>
        activateDeleteModal("imageDelete","imageid","deleteImageModal");
    </script>
@endsection
