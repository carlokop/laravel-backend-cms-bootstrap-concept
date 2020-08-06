@extends('layouts.admin')
@php 
    $title = "Bewerk bericht";
    $cats = ["Berichten"];
@endphp
@section('css')
    <link rel="stylesheet" href="{{asset('administrator/assets/vendor/multi-select/css/multi-select.css')}}">
    <link rel="stylesheet" href="{{asset('administrator/assets/libs/css/style.css')}}">
@endsection
@section('main')
    {!! Form::open(['method' => 'PATCH', 'route' => ['admin.posts.update',$post->id]]) !!}
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Header</h5>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                {!! Form::label('path', asset(''), ['class' => 'col-form-label pr-1', 'id' => 'slug']) !!}
                                @if($post->slug)
                                    {!! Form::text('path', $post->slug->path, ['class' => 'form-control','id' => 'path']) !!}
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
                            {!! Form::text('title', $post->title, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('intro', 'Intro text', ['class' => 'col-form-label']) !!}
                            {!! Form::text('intro', $post->intro, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h5 class="card-header">Content</h5>
                    <div class="card-body">
                        <div class="form-group">
                            {!! Form::label('content', 'Title', ['class' => 'col-form-label']) !!}
                            {!! Form::textarea('content', $post->content, ['class' => 'form-control']) !!}
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
                            <div class="form-group mt-2 clearfix">
                                {!! Form::submit('Publish', ['class'=> 'btn btn-primary float-right']) !!}
                            </div>
                            @include('admin.partials._errors')
                            
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h5 class="card-header">Categories</h5>
                    <div class="card-body">
                        <select multiple="multiple" id="callbacks" name="categories[]">
                            @foreach($categories as $category) 
                                <option value='{{$category->id}}'>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-body">
                        <div id="" class="">
                            @php
                                $cat_values = [null => 'No category',]; 
                                foreach($post->categories as $category) {
                                    $cat_values[$category->id] = $category->name;
                                }
                            @endphp
                            {!! Form::label('primarycategory', 'Category for URL', ['class' => 'col-form-label']) !!}
                            {!! Form::select('primaryCategory', $cat_values, $post->category_id, ['class'=> 'form-control', 'id' => 'dropdownPrimaryCategory']) !!}
                        </div>
                        <button type="button" id="btnAddcategoryToSlug" class="btn btn-primary mt-2">Add to URL</button>
                        <div class="alert alert-danger mt-2 d-none" id="alertAddCategoryToSlug"></div>
                    </div>
                </div>

                @include('admin.partials._featuredimage')

                @include('admin.partials._seosettings',[$post, $users])

            </aside>
        </div>
    {!! Form::close() !!}
    
@endsection

@section('js')

    <script src="{{asset('administrator/assets/vendor/multi-select/js/jquery.multi-select.js')}}"></script>
    <script>
        validateSlug(); //init front-end validation for the created slug when adding a category

        //categories
        var selectedCategories = [];

        $('#callbacks').multiSelect({
            afterSelect: function(values){
                for(var i=0; i<values.length; i++) {
                    selectedCategories.push(values[i]);
                }
                getCategories(selectedCategories,{{$post->category_id}});
            },
            afterDeselect: function(values){
                var j;
                for(var i=0; i<values.length; i++) {
                    j = selectedCategories.indexOf(values[i]);
                }
                selectedCategories.splice(j,1);
                getCategories(selectedCategories,{{$post->category_id}});
            }
        });

        //auto select categories for edit post
        var cats = [
            @php
                $activeCats = '';
                foreach($post->categories as $category) {
                    $activeCats = $activeCats . "'" . $category->id . "',";
                }
                echo $activeCats;
            @endphp
        ];

        $('#callbacks').multiSelect('select', cats);

        //update the slug in url
        var btnUpdateSlugWithCategory = document.querySelector('#btnAddcategoryToSlug');
        btnUpdateSlugWithCategory.addEventListener('click', updateSlugwithCategory);

    
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
