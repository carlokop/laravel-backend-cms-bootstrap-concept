@extends('layouts.admin')
@php 
    $title = "trash";
    $cats = ["Pages"];
@endphp

@section('main')
    <div class="row">
        <div class="col-12 mb-3">
            {!! Form::open(['method' => 'DELETE', 'class' => 'float-left', 'route' => 'admin.pages.emptytrash']) !!}
                <button type="submit" class="btn"><i class="far fa-trash-alt"></i> Empty trash</button>
            {!! Form::close(); !!}

            {!! Form::open(['method' => 'page', 'route' => 'admin.pages.restoretrash']) !!}
                <button type="submit" class="btn"><i class="fas fa-undo-alt"></i> Restore everything</button>
            {!! Form::close(); !!}
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
                                    <th>Title</th>
                                    <th>Path</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pages as $page)
                                {{-- @php 
                                    $category = $page->category_id != null ? App\Category::findOrFail($page->category_id) : false;
                                @endphp --}}
                                <tr>
                                    <td>{{$page->title}}</td>
                                    {{-- @if($category)
                                        <td>{{$category->slug->path}}/{{$page->slug->path}}</td>
                                    @else
                                        <td>{{$page->slug->path}}</td>
                                    @endif --}}
                                    <td>
                                        <div class="btn-group ml-auto">
                                            {!! Form::open(['method' => 'page', 'route' => ['admin.pages.restoretrashed',$page->id]]) !!}
                                            {!! Form::submit('Restore', ['class' => 'btn btn-sm btn-primary']) !!}
                                            {!! Form::close(); !!}

                                            {!! Form::open(['method' => 'DELETE', 'route' => ['admin.pages.destroytrashed',$page->id]]) !!}
                                                <button type="submit" class="btn btn-sm btn-outline"><i class="far fa-trash-alt"></i></button>
                                            {!! Form::close(); !!}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Title</th>
                                    <th>Path</th>
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
