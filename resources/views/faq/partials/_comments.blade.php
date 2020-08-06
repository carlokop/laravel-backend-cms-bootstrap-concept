<section id="comments">
    <div class="container">
        <div class="row">
            <div class="offset-lg-3 col-lg-6 text-center m-b-40">
                <div class="header-badge m-b-15">Comments</div>
                <h2 class="m-b-10"> 
                    {{$post->approvedCommentCount()}}
                    @if($post->approvedCommentCount() == 1)
                        Comment
                    @else
                        Comments
                    @endif
                </h2>
            </div>

            <div class="offset-lg-2 col-lg-8 m-b-40">

                @foreach ($post->comments->sortByDesc('created_at')->where('approved', true) as $comment)
                    @if($comment->comment_parent_id == null)
                        {{-- is parent --}}

                        <div class="d-flex align-items-start m-b-20">
                            <div class="oval-70 overflow-hidden m-r-30">
                                <img src="{{$comment->get_gravatar($comment->user->id)}}" alt="">
                            </div>
                            <div class="content w-100 flex-1">
                                <div class="row d-flex align-items-center">
                                    <div class="col-8">
                                        <span class="d-block text-color-heading">{{$comment->user->name}}</span>
                                        <span>{{$comment->created_at->diffForHumans()}}</span>
                                    </div>
                                    <div class="col-4">
                                        <a href="#" class="btn-reply pull-right" data-commentId="{{$comment->id}}"><i class="fa fa-reply"></i> Reply</a>
                                    </div>
                                    <div class="col-lg-12 m-t-10">
                                        <p>{{$comment->body}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divider m-b-20"></div>
                        
                        {{-- loop child of parent --}}
                        @foreach ($post->comments->sortByDesc('created_at') as $com)
                            @if($com->comment_parent_id == $comment->id)
                                <div class="d-flex align-items-start m-b-20 p-l-50">
                                    <div class="oval-70 overflow-hidden m-r-30">
                                        <img src="{{$com->get_gravatar($com->user->id)}}" alt="">
                                    </div>
                                    <div class="content w-100 flex-1">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-8">
                                                <span class="d-block text-color-heading">{{$com->user->name}}</span>
                                                <span>{{$com->created_at->diffForHumans()}}</span>
                                            </div>
                                            <div class="col-4">
                                                <a href="#" class="btn-reply pull-right" data-commentId="{{$comment->id}}"><i class="fa fa-reply"></i> Reply</a>
                                            </div>
                                            <div class="col-lg-12 m-t-10">
                                                <p>{{$com->body}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="divider m-b-20"></div>
                            @endif
                        @endforeach
                    @endif

                @endforeach

            </div>

            @if(empty($user))
                <div class="offset-lg-2 col-lg-8">
                    <h3 class="m-b-20">Add comment</h3>
                    <div id="commentReact"></div>
                    <p>To create a comment you will have to be logged in. Create a account below or <a href="{{route('login')}}" class="">login</a></p>
                    @include('faq.partials._commentFormUser')
                </div>
            @else
                <div class="offset-lg-2 col-lg-8">
                    <h3 class="m-b-20">Publish comment</h3>
                    <div id="commentReact"></div>
                    @include('faq.partials._commentForm')
                </div>
            @endif
        </div>
    </div>
</section>