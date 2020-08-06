@extends('layouts.admin')
@php 
    $title = "Users";
    $cats = [""];
@endphp

@section('main')
    <div class="row">
        <div class="col-12 mb-3">
        <a class="btn btn-primary" href="{{route('admin.users.create')}}">Add new user</a>
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
                                    <th>Username</th>
                                    <th>E-mail</th>
                                    <th>Role</th>
                                    <th>Verified</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role->name}}</td>
                                    <td>{{$user->email_verified_at != null ? "Yes" : "No"}}</td>
                                    <td>
                                        <div class="btn-group ml-auto">
                                            <a href="/admin/users/{{$user->id}}/edit" class="btn btn-sm btn-primary">Edit</a>
                                            <button type="submit" name="userDelete" class="btn btn-sm btn-outline userDelete" data-userid="{{$user->id}}"><i class="far fa-trash-alt"></i></button>
                                        </div>
                                        <!-- modal delete user confirmation -->
                                        <div class="modal" tabindex="-1" role="dialog" id="deleteUserModal-{{$user->id}}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h3 class="modal-title">Delete user</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <p class="alert alert-danger p-3" role="alert">You are about to delete user {{$user->name}}. This cannot be restored.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        {!! Form::model($user, ['method' => 'DELETE', 'route' => ['admin.users.destroy',$user->id]]) !!}
                                                        {!! Form::submit('Yes delete', ['class'=>'btn btn-primary']); !!}
                                                        {!! Form::button('No', ['class'=>'btn btn-danger','data-dismiss'=>'modal']); !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Username</th>
                                    <th>E-mail</th>
                                    <th>Role</th>
                                    <th>Verified</th>
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

    <script>
        activateDeleteModal("userDelete","userid","deleteUserModal");
    </script>

@endsection
