{!! Form::open(['method' => 'POST', 'route' => 'comments.storeuser', 'id' => 'commentForm']) !!}
    <div class="row pt-3">
        <div class="col-lg-12">
            <div class="form-item m-b-30">
                {!! Form::label('name', 'Username', ['class' => 'lbl']) !!}
                {!! Form::text('name', null, ['class' => 'input','placeholder' => 'Username']) !!}
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-item m-b-30">
                {!! Form::label('email', 'E-mailadres', ['class' => 'lbl']) !!}
                {!! Form::text('email', null, ['class' => 'input','placeholder' => 'E-mailaddress']) !!}
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-item m-b-30">
                {!! Form::label('password', 'Password', ['class' => 'lbl']) !!}
                {!! Form::password('password', ['class' => 'input', 'placeholder' => 'Fill in a password']) !!}
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-item m-b-30">
                {!! Form::label('password2', 'Password', ['class' => 'lbl']) !!}
                {!! Form::password('password2', ['class' => 'input', 'placeholder' => 'Enter your password again']) !!}
            </div>
        </div>
        <div class="col-lg-12">
            <div class="form-item m-b-30">
                {!! Form::label('comment', 'Comment', ['class' => 'lbl']) !!}
                {!! Form::textarea('comment', null, ['class' => 'textarea']) !!}
            </div>
        </div>
        {!! Form::hidden('post', $post->id) !!}
        {!! Form::hidden('postType', 'Post') !!}
        {!! Form::hidden('commentId', null, ['id'=> 'commentId']) !!}
        <div class="col-lg-12 text-center">
            @include('admin.partials._errors')
            {!! Form::submit('Submit', ['class'=> 'button button-primary transition-3d-hover']) !!}
        </div>
    </div>
{!! Form::close() !!}