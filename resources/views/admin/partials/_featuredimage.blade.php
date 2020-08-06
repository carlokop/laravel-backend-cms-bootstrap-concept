{{-- 
*  This template is used for the Featured image blok in the create and edit Pages and Posts
--}}

<div class="card">
    <h5 class="card-header">Featured image</h5>
    <div id="featuredImagePlaceholder">
        @if($image)
            <img src="/{{$image->imagefiles->last()->path}}" class="img-fluid p-2" alt="">
        @endif
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary" id="btnImage" data-toggle="modal" data-target="#modal-default"><i class="fas fa-image"></i> Select image</button>
        @if($image) 
            {!! Form::hidden('featured', $image->id, ['id' => 'featuredImageId']) !!}
        @else
            {!! Form::hidden('featured', null, ['id' => 'featuredImageId']) !!}
        @endif
    </div>

    <!-- modal delete user confirmation -->
    <div class="modal" tabindex="-1" role="dialog" id="mediaGalleryModal">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h3 class="modal-title">Images</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="gallery">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>