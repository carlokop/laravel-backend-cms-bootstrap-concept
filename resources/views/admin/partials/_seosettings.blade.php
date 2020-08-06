{{-- 
*  This template is used for the SEO settings in the create and edit Pages and Posts
*  In this template the $post object is used.
*  For use @include('admin.partials._seosettings',[$post = $page, $users]) 
--}}

<div class="card">
    <h5 class="card-header">SEO settings</h5>
    <div class="card-body">
        <div class="form-group">
            {!! Form::label('seo_title', 'SEO title', ['class' => 'col-form-label']) !!}
            {!! Form::text('seo_title', $post->seo_title, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('seo_description', 'SEO description', ['class' => 'col-form-label']) !!}
            {!! Form::text('seo_description', $post->seo_description, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('og_image', 'Image URL for social media', ['class' => 'col-form-label']) !!}
            {!! Form::text('og_image', $post->og_image, ['class' => 'form-control','placeholder' => 'https://']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('cannonical', 'Cannonical URL', ['class' => 'col-form-label']) !!}
            {!! Form::text('cannonical', $post->cannonical, ['class' => 'form-control','placeholder' => 'https://']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('author', 'Author', ['class' => 'col-form-label']) !!}
            <select id="author"  name="author" class="form-control">
                @foreach ($users as $user)
                    @if ($user->loggedin == true)
                        <option selected value="{{ $user->id }}">{{ $user->name }}</option>
                    @else
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endif
                @endforeach
            </select>

        </div>
        <div class="form-group">
            {!! Form::label('robots', 'Robots', ['class' => 'col-form-label']) !!}
            {!! Form::select('robots', [
                'index, follow' => 'index, follow', 
                'noindex, follow' => 'noindex, follow', 
                'noindex, nofollow' => 'noindex, nofollow'
            ], null, ['class'=> 'form-control']) !!}
        </div>
    </div>
</div>