@extends('layouts.admin')
@php 
    $title = "Trash";
    $cats = ["Comments"];
@endphp

@section('main')
    <div class="row">
        <div class="col-12 mb-3">
            {!! Form::open(['method' => 'DELETE', 'class' => 'float-left', 'route' => 'admin.comments.emptytrash']) !!}
                <button type="submit" class="btn"><i class="far fa-trash-alt"></i> Empty trash</button>
            {!! Form::close(); !!}

            {!! Form::open(['method' => 'POST', 'route' => 'admin.comments.restoretrash']) !!}
                <button type="submit" class="btn"><i class="fas fa-undo-alt"></i> Restore everything</button>
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
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>In article</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comments as $comment)
                                <tr>
                                    <td>{{$comment->user->name}}</td>
                                    <td>{{substr($comment->body, 0, 55)}}</td>
                                    <td>{{$comment->posts()->first()->title}}</td>
                                    <td>
                                        <div class="btn-group ml-auto">
                                            {!! Form::open(['method' => 'POST', 'route' => ['admin.comments.restoretrashed',$comment->id]]) !!}
                                            {!! Form::submit('Herstellen', ['class' => 'btn btn-sm btn-primary']) !!}
                                            {!! Form::close(); !!}

                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.comments.destroytrashed',$comment->id]]) !!}
                                                <button type="submit" class="btn btn-sm btn-outline"><i class="far fa-trash-alt"></i></button>
                                            {!! Form::close(); !!}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>In article</th>
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
