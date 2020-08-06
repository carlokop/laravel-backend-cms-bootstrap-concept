@extends('layouts.admin')
@php 
    $title = "Profile";
    $cats = ["Users"];
@endphp

@section('css')
    <link rel="stylesheet" href="{{asset('administrator/assets/vendor/datepicker/tempusdominus-bootstrap-4.css')}}" />
@endsection

@section('main')

{!! Form::open(['method' => 'PATCH','route' => ['admin.users.update',$user->id]]) !!}          
    <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-5 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="user-avatar text-center d-block">
                        <img src="{{$user->get_gravatar($user->email, $s = 128, $d = 'mp', $r = 'g')}}" class="rounded-circle user-avatar-xl">
                    </div>
                    <div class="text-center">
                        <h2 class="font-24 mb-0">{{$user->name}}</h2>
                        
                        <p>{{$user->jobtitle}}</p>
                    </div>
                </div>
                <div class="card-body">
                    <h3 class="font-16">Notifications</h3>
                    @php
                        $notificationsArray = explode(',', $user->notification_preference);
                        $emailNofifications = in_array('mail', $notificationsArray) ? true : false;
                    @endphp
                    <div class="form-group row">
                        <label class="col-12 col-sm-3 col-xl-2 col-form-label">E-mail</label>
                        <div class="col-12 col-sm-8 col-lg-6 col-xl-10 pt-1">
                            <div class="switch-button switch-button-success switch-button-sm">
                                {!! Form::checkbox('emailNotifications', null, $emailNofifications,['id'=> 'emailNotifications']) !!}
                                <span><label for="emailNotifications"></label></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top">
                    <h3 class="font-16">Contact Information</h3>
                    <div class="">
                        <ul class="list-unstyled mb-0">
                            @if(!empty($user->firstname))
                                <li class="mb-0"><i class="fas fa-fw fa-user mr-2"></i>{{ucfirst($user->firstname)}} 
                                    @if(!empty($user->middlename))
                                        {{" " . $user->middlename}}
                                    @endif
                                    {{ucfirst($user->lastname)}}
                                </li>
                            @endif
                            <li class="mb-2"><i class="fas fa-fw fa-envelope mr-2"></i>{{$user->email}}</li>
                            @if(!empty($user->phone))
                                <li class="mb-0"><i class="fas fa-fw fa-phone mr-2"></i>{{$user->phone}}</li>
                            @endif
                            @if(!empty($user->address))
                                <li class="mb-0"><i class="fas fa-fw fa-map-marker mr-2"></i>{{$user->address}}</li>
                                @if(!empty($user->zipcode)||!empty($user->city))
                                    <li class="mb-0 pl-4">{{$user->zipcode}} {{$user->city}}</li>
                                @endif
                            @endif
                            @if(!empty($user->dateofbirth))
                                <li class="mb-0"><i class="fas fa-fw fa-birthday-cake mr-2"></i>{{\Carbon\Carbon::parse($user->dateofbirth)->locale('en')->format('d-m-Y')}}</li>
                            @endif
                    </ul>
                    </div>
                </div>
                {{-- <div class="card-body border-top">
                    <h3 class="font-16">Rating</h3>
                    <h1 class="mb-0">4.8</h1>
                    <div class="rating-star">
                        <i class="fa fa-fw fa-star"></i>
                        <i class="fa fa-fw fa-star"></i>
                        <i class="fa fa-fw fa-star"></i>
                        <i class="fa fa-fw fa-star"></i>
                        <i class="fa fa-fw fa-star"></i>
                        <p class="d-inline-block text-dark">14 Reviews </p>
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-7 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Edit</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Username',array('class' => 'col-form-label')); !!}
                                {!! Form::text('name', $user->name, ['placeholder'=>'Username','class' => 'form-control']); !!}
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                {!! Form::label('email', 'E-mail Address',array('class' => 'col-form-label')); !!}
                                {!! Form::text('email', $user->email, ['placeholder'=>'E-mailaddress','class' => 'form-control']); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                {!! Form::label('password', 'Passsword',array('class' => 'col-form-label')); !!}
                                {!! Form::password('password', ['placeholder'=>'Password','class' => ['form-control'], 'id' => 'password']); !!}
                                <div class="invalid-feedback d-block" id="passwordMessage">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                {!! Form::label('password', 'Repeat password',array('class' => 'col-form-label')); !!}
                                {!! Form::password('password2', ['placeholder'=>'Repeat password','class' => ['form-control'], 'id' => 'password2']); !!}
                                <div class="invalid-feedback d-block" id="password2Message">
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($user->loggedInUserIsAdmin == true)
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('role', 'User role',array('class' => 'col-form-label')); !!}
                                    {!! Form::select('role', $roles, $user->role->id, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-body border-top">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                {!! Form::label('firstname', 'First name',array('class' => 'col-form-label')); !!}
                                {!! Form::text('firstname', $user->firstname, ['placeholder'=>'','class' => 'form-control']); !!}
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                {!! Form::label('middlename', 'Middle name',array('class' => 'col-form-label')); !!}
                                {!! Form::text('middlename', $user->middlename, ['placeholder'=>'','class' => 'form-control']); !!}
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                                {!! Form::label('lastname', 'Last name',array('class' => 'col-form-label')); !!}
                                {!! Form::text('lastname', $user->lastname, ['placeholder'=>'','class' => 'form-control']); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                {!! Form::label('address', 'Address',array('class' => 'col-form-label')); !!}
                                {!! Form::text('address', $user->address, ['placeholder'=>'Street and house number','class' => 'form-control']); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                {!! Form::label('zipcode', 'Zipcode',array('class' => 'col-form-label')); !!}
                                {!! Form::text('zipcode', $user->zipcode, ['placeholder'=>'Zipcode','class' => 'form-control']); !!}
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                {!! Form::label('city', 'City',array('class' => 'col-form-label')); !!}
                                {!! Form::text('city', $user->city, ['placeholder'=>'City','class' => 'form-control']); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                {!! Form::label('phone', 'Phone number',array('class' => 'col-form-label')); !!}
                                {!! Form::text('phone', $user->phone, ['placeholder'=>'Phone number','class' => 'form-control']); !!}
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                {!! Form::label('jobtitle', 'Job title',array('class' => 'col-form-label')); !!}
                                {!! Form::text('jobtitle', $user->jobtitle, ['placeholder'=>'Job title','class' => 'form-control']); !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                {!! Form::label('dateofbirth', 'Birthday',array('class' => 'col-form-label')); !!}
                                <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker4" name="dateofbirth" value="{{$user->dateofbirth}}"/>
                                    <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $urlArray = explode('/',Request::url());
                        $urlLast = array_pop($urlArray);
                    @endphp
                    {!! Form::hidden('page', $urlLast); !!}
                    <div class="row">
                        <div class="col-12">
                            {!! Form::submit('Update profile', ['class'=>'btn btn-primary']); !!}
                        </div>
                    </div>
                </div>
                @include('admin.partials._errors')
            </div>
        </div>
    </div>
{!! Form::close() !!}

               
@endsection

@section('js')
        <script src="{{asset('administrator/assets/vendor/datepicker/moment.js')}}"></script>
        <script src="{{asset('administrator/assets/vendor/datepicker/tempusdominus-bootstrap-4.js')}}"></script>
        <script src="{{asset('administrator/assets/vendor/datepicker/datepicker.js')}}"></script>
        <script>
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
        </script>
@endsection
