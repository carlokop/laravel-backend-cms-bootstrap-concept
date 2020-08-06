@extends('layouts.admin')
@php 
    $title = "General settings";
    $cats = [""];
@endphp

@section('main')

    <div class="row">
        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
            {!! Form::open(['method' => 'PATCH','route' => ['admin.settings.update',1]]) !!}
            <div class="mt-2 mb-3">
                @php
                    $activeHomepage = null;
                    foreach($pages as $page) {
                        if(!empty($page)) {
                            if($page->slug->homepage) $activeHomepage = $page->slug->id;
                            $page_values[$page->id] = $page->title;
                        }
                    }
                        
                    //$activeHomepage = array_pop($pages)->id;
                @endphp
                @if(!empty($pages[0]))
                {!! Form::label('homepage', 'Homepage', ['class' => 'col-form-label']) !!} 
                {!! Form::select('homepage', $page_values, $activeHomepage, ['class'=> 'form-control', 'id' => 'homepageDropdown']) !!}
                @else
                    <div class="alert alert-danger">First create a new <a href="{{route('admin.pages')}}">page</a></div>
                @endif
            </div> 
            @if(!empty($pages[0]))
                {!! Form::submit('verzenden', ['class'=>'btn btn-primary']); !!}
            @endif
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('js')
@endsection