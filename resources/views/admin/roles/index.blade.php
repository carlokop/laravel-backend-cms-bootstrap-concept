@extends('layouts.admin')
@php 
    $title = "Roles";
    $cats = [""];
@endphp

@section('main')
    <div class="row">
        <div class="col-12 mb-3">
            <a class="btn btn-primary" href="{{route('admin.roles.create')}}">Add new role</a>
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
                                    <th>Name</th>
                                    <th>Actions</th>
                                    <th>Number of users</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        <div class="btn-group ml-auto">
                                            @if($role->id > 2)
                                                <button type="submit" name="userRole" class="btn btn-sm btn-outline userRole" data-roleid="{{$role->id}}"><i class="far fa-trash-alt"></i></button>
                                            @endif
                                        </div>
                                        <!-- modal delete user confirmation -->
                                        <div class="modal" tabindex="-1" role="dialog" id="deleteRoleModal-{{$role->id}}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h3 class="modal-title">Delete role</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <p class="alert alert-danger p-3" role="alert">You are about to delete role {{$role->name}}. This cannot be restored.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        {!! Form::model($role, ['method' => 'DELETE', 'route' => ['admin.roles.destroy',$role->id]]) !!}
                                                        {!! Form::submit('Yes delete', ['class'=>'btn btn-primary']); !!}
                                                        {!! Form::button('No', ['class'=>'btn btn-danger','data-dismiss'=>'modal']); !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$role->users->count()}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Actions</th>
                                    <th>Number of users</th>
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
        activateDeleteModal("userRole","roleid","deleteRoleModal");
    </script>

@endsection
