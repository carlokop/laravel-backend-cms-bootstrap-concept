<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin')}}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.users.profile')}}"><i class="fas fa-fw fa-user"></i>Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#menu-pages" aria-controls="menu-pages"><i class="fas fa-fw fa-file-alt"></i> Pages </a>
                        <div id="menu-pages" class="collapse submenu" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.pages')}}">All pages</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.pages.create')}}">New page</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#menu-template" aria-controls="menu-template">Page templates</a>
                                    <div id="menu-template" class="collapse submenu" style="">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('admin.pages.templates')}}">All page templates</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('admin.pages.templates.create')}}">New page template</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.comments')}}">
                            <i class="fas fa-comments"></i>Comments

                            @if($commentOpenCount)
                                <span class="badge badge-secondary d-inline-block">{{$commentOpenCount}}</span>
                            @endif   
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#menu-faq" aria-controls="menu-faq"><i class="fas fa-newspaper"></i> Posts </a>
                        <div id="menu-faq" class="collapse submenu" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.posts')}}">All posts</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.posts.create')}}">New post</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#menu-faq-cat" aria-controls="menu-faq-cat">Categories</a>
                                    <div id="menu-faq-cat" class="collapse submenu" style="">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('admin.posts.category')}}">All categories</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('admin.posts.category.create')}}">New category</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#menu-users" aria-controls="menu-users"><i class="fa fa-fw fa-user-circle"></i>Users</a>
                        <div id="menu-users" class="collapse submenu" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.users')}}">All users</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.users.create')}}">add new user</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.roles')}}">User roles</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.media')}}"><i class="far fa-fw fa-images"></i>Media</a></a>
                    </li>
                    
                    <li class="nav-divider">
                        Features
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#menu-settings" aria-controls="menu-settings"><i class="fas fa-fw fa-wrench"></i>Settings <span class="badge badge-secondary">New</span></a>
                        <div id="menu-settings" class="collapse submenu" style="">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('admin.settings')}}">General</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>