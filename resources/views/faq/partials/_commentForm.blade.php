{!! Form::open(['method' => 'POST', 'route' => 'comments.store', 'id' => 'commentForm']) !!}
    <div class="row pt-3">
        <div class="col-lg-12">
            <div class="form-item m-b-30">
                {!! Form::label('comment', 'Reactie', ['class' => 'lbl float-left']) !!}
                <a class="float-right" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <div id="msgComment">
                    @if ($message = Session::get('status'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                </div>
                {!! Form::textarea('comment', null, ['class' => 'textarea']) !!}
            </div>
        </div>
        {!! Form::hidden('post', $post->id) !!}
        {!! Form::hidden('postType', 'Post') !!}
        {!! Form::hidden('ajax', true) !!}
        {!! Form::hidden('commentId', null, ['id'=> 'commentId']) !!}
        <div class="col-lg-12 text-center">
            @include('admin.partials._errors')
            {!! Form::submit('Submit', ['class'=> 'button button-primary transition-3d-hover']) !!}
        </div>
    </div>
{!! Form::close() !!}
<form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
    {{ csrf_field() }}
</form>
