@extends('layouts.admin')
@php 
    $title = "New page";
    $cats = ["Pages"];
@endphp
@section('css')
    <link rel="stylesheet" href="{{asset('administrator/assets/vendor/multi-select/css/multi-select.css')}}">
    <link rel="stylesheet" href="{{asset('administrator/assets/libs/css/style.css')}}">
@endsection
@section('main')
    {!! Form::open(['method' => 'POST', 'route' => 'admin.pages.store']) !!}
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Header</h5>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                {!! Form::label('path', asset(''), ['class' => 'col-form-label pr-1', 'id' => 'slug']) !!}
                                @if($page->slug)
                                    {!! Form::text('path', $page->slug->path, ['class' => 'form-control','id' => 'path']) !!}
                                @else
                                    {!! Form::text('path', null, ['class' => 'form-control','id' => 'path']) !!}
                                @endif
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" id="btnPath">Ok</button>
                                </div>
                            </div>
                            <div class="alert alert-danger mt-2 d-none" id="messagePath"></div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('title', 'Title', ['class' => 'col-form-label']) !!}
                            {!! Form::text('title', $page->title, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('intro', 'Intro text', ['class' => 'col-form-label']) !!}
                            {!! Form::text('intro', $page->intro, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h5 class="card-header">Content</h5>
                    <div class="card-body">
                        <div class="form-group">
                            {!! Form::label('content', 'Title', ['class' => 'col-form-label']) !!}
                            {!! Form::textarea('content', $page->content, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <aside class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Page attributes</h5>
                    <div class="card-body">
                        <div class="form-group pt-2">
                            <div class="switch-button switch-button-success switch-button-sm">
                                {!! Form::checkbox('published', null, true,['checked' => 'checked', 'id'=> 'published']) !!}
                                <span><label for="published"></label></span>
                            </div>
                            <span class="pl-2">Status</span>

                            <div class="mt-2">
                                @php
                                    $parent_id = $page->parent_id == null ? 0 : $page->parent_id;
                                    $page_values[0] = '--No parent';
                                    foreach($pages as $page) {
                                        $page_values[$page->id] = $page->title;
                                    }
                                @endphp
                                {!! Form::label('hoofd', 'Parent', ['class' => 'col-form-label']) !!} 
                                {!! Form::select('hoofd', $page_values, $parent_id, ['class'=> 'form-control', 'id' => 'dropdownPrimaryCategory']) !!}
                            </div> 

                            <div class="mt-2">
                                @php
                                    foreach($templates as $template) {
                                        $template_values[$template->id] = $template->name;
                                    }
                                @endphp
                                {!! Form::label('template', 'Page template', ['class' => 'col-form-label']) !!}
                                {!! Form::select('template', $template_values, $page->template, ['class'=> 'form-control', 'id' => 'dropdownPrimaryCategory']) !!}
                            </div>
                            <div class="form-group mt-2 clearfix">
                                {!! Form::submit('Publish', ['class'=> 'btn btn-primary float-right']) !!}
                            </div>
                            @include('admin.partials._errors')
                            
                        </div>
                    </div>
                </div>

                @include('admin.partials._featuredimage')

                @include('admin.partials._seosettings',[$post = $page, $users])

            </aside>
        </div>
    {!! Form::close() !!}
    
@endsection

@section('js')

    <script src="{{asset('administrator/assets/vendor/multi-select/js/jquery.multi-select.js')}}"></script>
    <script>
        validateSlug(); //init front-end validation for the created slug when adding a category

        // //update the slug in url
        // var btnUpdateSlugWithCategory = document.querySelector('#btnAddcategoryToSlug');
        // btnUpdateSlugWithCategory.addEventListener('click', updateSlugwithCategory);

    
        //init modal featured image
        var galleryLoaded = false;
        var btnMediaGallery = document.querySelector('#btnImage');
        btnMediaGallery.addEventListener("click",function(){
            $('#mediaGalleryModal').modal();
            if(galleryLoaded == false) {
                loadGallery();
                galleryLoaded = true;
            }
        });

        

        

        


       


    </script>
@endsection
