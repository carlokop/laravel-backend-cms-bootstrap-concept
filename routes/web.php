<?php

use Illuminate\Support\Facades\Route;
use App\Page;
use App\Slug;
use App\Post;
use App\User;
use App\Role;
use App\Image;
use App\Review;
use App\Comment;
use App\Category;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Login
Auth::routes();

Route::get('/resetnew', function () {
    return view('auth.emailnew');
});

//Homepage
Route::get('/', 'PageController@index');

/***************************************
* User is logged in and Admin user
* Routes for admin panel
****************************************/
Route::group(['middleware' => ['auth','IsAdmin','web'],'namespace' => 'Admin'] , function() {

    Route::get('/admin', 'AdminController@index')->name('admin');

    //users
    Route::get('/admin/users/profile', 'AdminUsersController@profile')->name('admin.users.profile');
    Route::resource('/admin/users', 'AdminUsersController', [
        'names' => [
            'index' => 'admin.users',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]
    ]);

    //roles
    Route::resource('/admin/roles', 'AdminRolesController', [
        'names' => [
            'index' => 'admin.roles',
            'create' => 'admin.roles.create',
            'store' => 'admin.roles.store',
            'destroy' => 'admin.roles.destroy',
        ]
    ]);

    //media
    Route::get('/admin/media/{id}', 'AdminMediaController@show')->name('admin.media.show');
    Route::resource('/admin/media', 'AdminMediaController', [
        'names' => [
            'index' => 'admin.media',
            'update' => 'admin.media.update',
            'store' => 'admin.media.store',
            'destroy' => 'admin.media.destroy',
        ]
    ]);

    //posts category
    Route::resource('/admin/posts/category', 'AdminPostCategoryController', [
        'names' => [
            'index' => 'admin.posts.category',
            'create' => 'admin.posts.category.create',
            'store' => 'admin.posts.category.store',
            'edit' => 'admin.posts.category.edit',
            'update' => 'admin.posts.category.update',
            'destroy' => 'admin.post.category.destroy',
        ]
    ]);

    //posts
    Route::get('/admin/posts/trash', 'AdminPostController@trash')->name('admin.posts.trash');
    Route::post('/admin/posts/restoretrash', 'AdminPostController@restoretrash')->name('admin.posts.restoretrash');
    Route::post('/admin/posts/restoretrashed/{id}', 'AdminPostController@restoretrashed')->name('admin.posts.restoretrashed');
    Route::delete('/admin/posts/emptytrash', 'AdminPostController@emptytrash')->name('admin.posts.emptytrash');
    Route::delete('/admin/posts/destroytrashed/{id}', 'AdminPostController@destroytrashed')->name('admin.posts.destroytrashed');
    Route::resource('/admin/posts', 'AdminPostController', [
        'names' => [
            'index' => 'admin.posts',
            'create' => 'admin.posts.create',
            'store' => 'admin.posts.store',
            'edit' => 'admin.posts.edit',
            'update' => 'admin.posts.update',
            'destroy' => 'admin.post.destroy',
        ]
    ]);

    //comments
    Route::get('/admin/comments/trash', 'AdminCommentController@trash')->name('admin.comments.trash');
    Route::post('/admin/comments/restoretrash', 'AdminCommentController@restoretrash')->name('admin.comments.restoretrash');
    Route::post('/admin/comments/restoretrashed/{id}', 'AdminCommentController@restoretrashed')->name('admin.comments.restoretrashed');
    Route::delete('/admin/comments/emptytrash', 'AdminCommentController@emptytrash')->name('admin.comments.emptytrash');
    Route::delete('/admin/comments/destroytrashed/{id}', 'AdminCommentController@destroytrashed')->name('admin.comments.destroytrashed');
    Route::resource('/admin/comments', 'AdminCommentController', [
        'names' => [
            'index' => 'admin.comments',
            // 'create' => 'admin.comments.create',
            // 'store' => 'admin.comments.store',
            'edit' => 'admin.comments.edit',
            'update' => 'admin.comments.update',
            'destroy' => 'admin.comments.destroy',
        ]
    ]);

    //pagina templates
    Route::resource('/admin/pages/templates', 'AdminPageTemplateController', [
        'names' => [
            'index' => 'admin.pages.templates',
            'create' => 'admin.pages.templates.create',
            'store' => 'admin.pages.templates.store',
            'edit' => 'admin.pages.templates.edit',
            'update' => 'admin.pages.templates.update',
            'destroy' => 'admin.pages.templates.destroy',
        ]
    ]);

    //pages
    Route::get('/admin/pages/trash', 'AdminPageController@trash')->name('admin.pages.trash');
    Route::post('/admin/pages/restoretrash', 'AdminPageController@restoretrash')->name('admin.pages.restoretrash');
    Route::post('/admin/pages/restoretrashed/{id}', 'AdminPageController@restoretrashed')->name('admin.pages.restoretrashed');
    Route::delete('/admin/pages/emptytrash', 'AdminPageController@emptytrash')->name('admin.pages.emptytrash');
    Route::delete('/admin/pages/destroytrashed/{id}', 'AdminPageController@destroytrashed')->name('admin.pages.destroytrashed');
    Route::resource('/admin/pages', 'AdminPageController', [
        'names' => [
            'index' => 'admin.pages',
            'create' => 'admin.pages.create',
            'store' => 'admin.pages.store',
            'edit' => 'admin.pages.edit',
            'update' => 'admin.pages.update',
            'destroy' => 'admin.pages.destroy',
        ]
    ]);

    //Settings
    Route::get('/admin/settings', 'AdminSettingsController@index')->name('admin.settings');
    Route::resource('/admin/settings', 'AdminSettingsController', [
        'names' => [
            'index' => 'admin.settings',
            'create' => 'admin.settings.create',
            'store' => 'admin.settings.store',
            'edit' => 'admin.settings.edit',
            'update' => 'admin.settings.update',
            'destroy' => 'admin.settings.destroy',
        ]
    ]);
    

    //Notification
    Route::delete('/admin/notifications/destroyAll', 'AdminNotificationController@destroyAll')->name('admin.notifications.destroyAll');
    Route::resource('/admin/notifications', 'AdminNotificationController', [
        'names' => [
            'destroy' => 'admin.notifications.destroy',
        ]
    ]);

});



/***************************************
 * Front-end Routes
 *******************************************/

//Blog routes require /blog/ in url
Route::get('/blog', 'PostController@index');
Route::get('/blog/{post}', 'PostController@routingSingle');
Route::get('/blog/{category}/{post}', 'PostController@routingCategory');


Route::post('/comments/storeuser', 'CommentController@storeuser')->name('comments.storeuser');
Route::resource('/comments', 'CommentController', [
    'names' => [
        'index' => 'comments',
        'create' => 'comments.create',
        'store' => 'comments.store',
        'edit' => 'comments.edit',
        'update' => 'comments.update',
    ]
]);


/********************************************
 * Pages routes
*  We validate if the page exsists in the slugs table
*  We can exept one parent page in the url
**********************************************
*/
Route::get('/{slug}', 'PageController@routingSingle');
Route::get('/{parent}/{child}', 'PageController@routingChild');




