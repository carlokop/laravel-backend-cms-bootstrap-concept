@extends('layouts.admin')
@php 
    $title = "Add Category";
    $cats = ["Posts","Categories"];
@endphp

@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['method' => 'POST', 'class' => 'row', 'route' => ['admin.posts.category.store',$category->id]]) !!}
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('name','Category name',['class' => 'col-form-label']) !!}
                            {!! Form::text('name', $category->name, ['class' => 'form-control']) !!}

                            {!! Form::label('path','Slug',['class' => 'col-form-label']) !!}
                            {!! Form::text('path', null, ['class' => 'form-control']) !!}
                        </div>
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                        @include('admin.partials._errors')
                    </div>
                    {!! Form::close(); !!}
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
