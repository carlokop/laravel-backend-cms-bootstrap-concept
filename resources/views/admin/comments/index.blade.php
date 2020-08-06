@extends('layouts.admin')
@php 
    $title = "Comments";
    $cats = [""];
@endphp

@section('main')

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('admin.comments.trash')}}" class="btn btn-sm btn-outline no-link text-black" data-toggle="tooltip" data-placement="top" title="Trash"><i class="far fa-trash-alt"></i></a>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th>Author</th>
                                    <th>Comments</th>
                                    <th>Actions</th>
                                    <th>Reacted at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comments as $comment)
                                <tr>
                                    <td>{{$comment->user->name}}</td>
                                    <td>{{substr($comment->body, 0, 55)}}</td>
                                    <td>
                                        <div class="btn-group ml-auto">
                                            @if($comment->approved == false)
                                                {!! Form::open(['method' => 'PATCH', 'route' => ['admin.comments.update',$comment->id]]) !!}
                                                    {!! Form::hidden('approved', 'on') !!}
                                                    {!! Form::hidden('body', $comment->body) !!}
                                                    <button type="submit" class="btn btn-sm btn-success mr-2">Approve</button>
                                                {!! Form::close(); !!}
                                            @endif
                                            <a href="/admin/comments/{{$comment->id}}/edit" class="btn btn-sm btn-primary">Edit</a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.comments.destroy',$comment->id]]) !!}
                                                <button type="submit" class="btn btn-sm btn-outline"><i class="far fa-trash-alt"></i></button>
                                            {!! Form::close(); !!}
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $post = $comment->posts->first();
                                        @endphp
                                        <span class="badge badge-dark">{{$post->comments->count()}}</span> {{$comment->posts()->first()->title}}
                                        @if($comment->comment_parent_id)
                                            <span class="badge badge-secondary d-inline-block ml-2">Answer</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Author</th>
                                    <th>Comments</th>
                                    <th>Actions</th>
                                    <th>Reacted at</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end basic table  -->
        <!-- ============================================================== -->
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('administrator/assets/vendor/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('administrator/assets/vendor/datatables/js/data-table.js')}}"></script>

    <script>
        
    </script>

@endsection
