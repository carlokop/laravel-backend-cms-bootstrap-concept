@extends('layouts.admin')
@php 
    $title = "Add user";
    $cats = ["Users"];
@endphp

@section('main')
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Add new user</h5>
                <div class="card-body">
                    {!! Form::open(['method' => 'POST','route' => 'admin.users.store', 'class' => ['needs-validation'], 'novalidate' => true]) !!}
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                {!! Form::label('name', 'Username'); !!}
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                                    </div>
                                    {!! Form::text('name', null, ['placeholder'=>'Username','class' => ['form-control'], 'required' => 'required']); !!}
                                    <div class="invalid-feedback">
                                        Choose a username
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('email', 'E-mailadres'); !!}
                                    {!! Form::email('email', null, ['placeholder'=>'E-mail Address','class' => ['form-control'], 'required' => 'required', 'data-parsley-trigger' => 'change']); !!}
                                    <div class="invalid-feedback">
                                        Use a valid e-mailaddress
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-lg-3">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('password', 'Password'); !!}
                                    {!! Form::password('password', ['placeholder'=>'Password','class' => ['form-control'], 'id' => 'password', 'required' => 'required', 'data-parsley-minlength' => '6']); !!}
                                    <div class="invalid-feedback d-block" id="passwordMessage">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('password', 'Repeat password'); !!}
                                    {!! Form::password('password2', ['placeholder'=>'Password','class' => ['form-control'], 'id' => 'password2', 'required' => 'required', 'data-parsley-minlength' => '6', 'data-parsley-equalto' => 'password']); !!}
                                    <div class="invalid-feedback d-block" id="password2Message">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-lg-3">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('role_id', 'Choose role'); !!}
                                    {{-- <select name="role" id="role" class="form-control">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach 
                                    </select> --}}
                                    {!! Form::select('role_id', ['' => 'Choose option'] + $roles, null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Submit', ['class'=>'btn btn-primary']); !!}
                        </div>
                    {!! Form::close() !!}
                    @include('admin.partials._errors')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

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
            var password = document.getElementById("password");
            var password2 = document.getElementById("password2");
            var passwordMessage = document.getElementById("passwordMessage");
            var password2Message = document.getElementById("password2Message");
            password.addEventListener("change", function() {
                if(password.value.length < 8) {
                    passwordMessage.innerHTML = "Choose a password with a minimum of 8 characters";
                } else {
                    passwordMessage.innerHTML = "";
                }
            });
            password2.addEventListener("change", function() {
                if(password.value == password2.value) {
                    password2Message.innerHTML = "";
                } else {
                    password2Message.innerHTML = "The passwords do not match";
                }
            });
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
