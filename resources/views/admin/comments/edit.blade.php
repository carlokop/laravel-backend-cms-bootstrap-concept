@extends('layouts.admin')
@php 
    $title = "Ecit comment";
    $cats = ["Comments"];
@endphp
@section('css')
    <link rel="stylesheet" href="{{asset('administrator/assets/vendor/multi-select/css/multi-select.css')}}">
    <link rel="stylesheet" href="{{asset('administrator/assets/libs/css/style.css')}}">
@endsection
@section('main')
    {!! Form::open(['method' => 'PATCH', 'route' => ['admin.comments.update',$comment->id]]) !!}
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Content</h5>
                    <div class="card-body">
                        @php
                            $post = $comment->posts()->first();
                            $category = $post->category_id != null ? App\Category::findOrFail($post->category_id) : false;
                            $slug = $category ? $category->slug->path : $post->slug->path
                        @endphp
                        <p>Comment placed on: {{$post->title}}</p>

                        @if($comment->comment_parent_id)
                            <p>This comment is an reaction on: {{App\Comment::whereId($comment->comment_parent_id)->first()->body}}</p>
                        @endif
                        <div class="form-group">
                            {!! Form::label('body', 'Reactie', ['class' => 'col-form-label']) !!}
                            {!! Form::textarea('body', $comment->body, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <aside class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Publish</h5>
                    <div class="card-body">
                        <div class="form-group pt-2">
                            <div class="switch-button switch-button-success switch-button-sm">
                                @if($comment->approved == true)
                                    {!! Form::checkbox('approved', null, true,['checked' => 'checked', 'id'=> 'approved']) !!}
                                @else
                                    {!! Form::checkbox('approved', null, false,['id'=> 'approved']) !!}
                                @endif
                                <span><label for="approved"></label></span>
                            </div>
                            <span class="pl-2">Published</span>
                            <div class="form-group mt-2 clearfix">
                                {!! Form::submit('Publiceren', ['class'=> 'btn btn-primary float-right']) !!}
                            </div>
                            @include('admin.partials._errors')
                        </div>
                    </div>
                </div>

            </aside>

            
        </div>
    {!! Form::close() !!}
    
@endsection

@section('js')
@endsection
