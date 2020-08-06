@extends('layouts.admin')
@php 
    $title = "Posts";
    $cats = [""];
@endphp

@section('main')
    <div class="row">
        <div class="col-12 mb-3">
            <a class="btn btn-primary" href="{{route('admin.posts.create')}}">New post</a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                <a href="{{route('admin.posts.trash')}}" class="btn btn-sm btn-outline no-link text-black" data-toggle="tooltip" data-placement="top" title="Trash"><i class="far fa-trash-alt"></i></a>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Path</th>
                                    <th>Categories</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                @php 
                                    $category = $post->category_id != null ? App\Category::findOrFail($post->category_id) : false;
                                @endphp
                                <tr>
                                    <td>{{$post->title}}</td>
                                    @if($category)
                                        <td>{{$category->slug->path}}/{{$post->slug->path}}</td>
                                    @else
                                        <td>{{$post->slug->path}}</td>
                                    @endif
                                    <td>
                                        @foreach($post->categories as $cats)
                                            <span class="btn btn-rounded btn-brand btn-xs">{{ucfirst($cats->name)}}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="btn-group ml-auto">
                                            <a href="/admin/posts/{{$post->id}}/edit" class="btn btn-sm btn-primary">Edit</a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.post.destroy',$post->id]]) !!}
                                                <button type="submit" class="btn btn-sm btn-outline"><i class="far fa-trash-alt"></i></button>
                                            {!! Form::close(); !!}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Title</th>
                                    <th>Path</th>
                                    <th>Categories</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
