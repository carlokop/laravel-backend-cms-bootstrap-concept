@extends('layouts.admin')
@php 
    $title = "Categories";
    $cats = ["Posts"];
@endphp

@section('main')
    <div class="row">
        <div class="col-12 mb-3">
            <a class="btn btn-primary" href="{{route('admin.posts.category.create')}}">Add new category</a>
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
                                    <th>Name</th>
                                    <th>Path</th>
                                    <th>posts</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ucfirst($category->name)}}</td>
                                    <td>{{$category->slug->path}} </td>
                                    <td>
                                        @if($category->posts()->get())
                                            {{$category->posts()->count()}}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group ml-auto">
                                            <a href="/admin/posts/category/{{$category->id}}/edit" class="btn btn-sm btn-primary">Edit</a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.post.category.destroy',$category->id]]) !!}
                                                <button type="submit" class="btn btn-sm btn-outline"><i class="far fa-trash-alt"></i></button>
                                            {!! Form::close(); !!}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Path</th>
                                    <th>posts</th>
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

@section('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('administrator/assets/vendor/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('administrator/assets/vendor/datatables/js/data-table.js')}}"></script>
@endsection
