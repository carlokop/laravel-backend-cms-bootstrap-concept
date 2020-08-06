@extends('layouts.admin')
@php 
    $title = "Add template";
    $cats = ["Pages","Templates"];
@endphp

@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['method' => 'POST', 'class' => 'row', 'route' => ['admin.pages.templates.store',$template->id]]) !!}
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            {!! Form::label('name','Template name',['class' => 'col-form-label']) !!}
                            {!! Form::text('name', $template->name, ['class' => 'form-control']) !!}

                            {!! Form::label('filename','File name',['class' => 'col-form-label']) !!}
                            {!! Form::text('filename', null, ['class' => 'form-control']) !!}
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
