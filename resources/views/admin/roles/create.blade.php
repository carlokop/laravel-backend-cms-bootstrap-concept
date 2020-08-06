@extends('layouts.admin')
@php 
    $title = "Add new role";
    $cats = ["User roles"];
@endphp

@section('main')
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Add user role</h5>
                <div class="card-body">
                    {!! Form::open(['method' => 'POST','role' => 'admin.roles.store', 'class' => ['needs-validation'], 'novalidate' => true]) !!}
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <div class="form-group">
                                    {!! Form::label('name', 'Role name'); !!}
                                    {!! Form::text('name', null, ['placeholder'=>'Rol naam','class' => ['form-control'], 'required' => 'required']); !!}
                                    <div class="invalid-feedback">
                                        Add the name of the role
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::submit('Submit', ['class'=>'btn btn-primary']); !!}
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    @include('admin.partials._errors')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    
    <script src="{{asset('administrator/assets/js/custom.js')}}"></script>
    <script src="{{asset('administrator/assets/vendor/parsley/parsley.js')}}"></script>
    <script>
        $('#form').parsley();
    </script>
    <script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    </script>

@endsection
