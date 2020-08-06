@extends('layouts.admin')
@php 
    $title = "Templates";
    $cats = ["Pages"];
@endphp

@section('main')
    <div class="row">
        <div class="col-12 mb-3">
            <a class="btn btn-primary" href="{{route('admin.pages.templates.create')}}">New template</a>
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
                                    <th>Action</th>
                                    <th>Number of pages</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($templates as $template)
                                <tr>
                                    <td>{{ucfirst($template->name)}}</td>
                                    <td>
                                        <div class="btn-group ml-auto">
                                            @if($template->id != 1)
                                                <button type="submit" name="pageTemplate" class="btn btn-sm btn-outline pageTemplate" data-templateid="{{$template->id}}"><i class="far fa-trash-alt"></i></button>
                                            @endif
                                        </div>
                                        <!-- modal delete confirmation -->
                                        <div class="modal" tabindex="-1" role="dialog" id="deleteTemplateModal-{{$template->id}}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h3 class="modal-title">Delete template</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <p class="alert alert-danger p-3" role="alert">You are about to delete template {{$template->name}}. This cannot be restored.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        {!! Form::model($template, ['method' => 'DELETE', 'route' => ['admin.pages.templates.destroy',$template->id]]) !!}
                                                        {!! Form::submit('Yes delete', ['class'=>'btn btn-primary']); !!}
                                                        {!! Form::button('No', ['class'=>'btn btn-danger','data-dismiss'=>'modal']); !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Action</th>
                                    <th>Number of pages</th>
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
    <script>
        activateDeleteModal("pageTemplate","templateid","deleteTemplateModal");
    </script>
@endsection
