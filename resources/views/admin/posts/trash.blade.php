@extends('layouts.admin')
@php 
    $title = "Trash";
    $cats = ["Posts"];
@endphp

@section('main')
    <div class="row">
        <div class="col-12 mb-3">
            {!! Form::open(['method' => 'DELETE', 'class' => 'float-left', 'route' => 'admin.posts.emptytrash']) !!}
                <button type="submit" class="btn"><i class="far fa-trash-alt"></i> Empty trash</button>
            {!! Form::close(); !!}

            {!! Form::open(['method' => 'POST', 'route' => 'admin.posts.restoretrash']) !!}
                <button type="submit" class="btn"><i class="fas fa-undo-alt"></i> Recover all</button>
            {!! Form::close(); !!}
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Path</th>
                                    <th>Actions</th>
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
                                        <div class="btn-group ml-auto">
                                            {!! Form::open(['method' => 'POST', 'route' => ['admin.posts.restoretrashed',$post->id]]) !!}
                                            {!! Form::submit('Recover', ['class' => 'btn btn-sm btn-primary']) !!}
                                            {!! Form::close(); !!}

                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.posts.destroytrashed',$post->id]]) !!}
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
