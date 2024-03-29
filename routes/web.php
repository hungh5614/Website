<?php

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

Route::group(['namespace' => 'BackEnd'], function () {

    // Login và Register
    Route::group(['namespace' => 'Auth'], function () {

        Route::get('/', 'LoginController@index')->name('backend.index');
        Route::post('/login', 'LoginController@login')->name('backend.login');

        Route::get('/register', 'RegisterController@index')->name('backend.register');
        Route::post('/register', 'RegisterController@register')->name('backend.register.create');

    });

    // Login Thành công
    Route::group([
        'middleware' => 'admin'
    ], function () {

        // Dashboard và logout
        Route::get('/dashboard', 'HomeController@index')->name('backend.dashboard');
        Route::get('/logout', 'HomeController@logout')->name('backend.logout');


        // Administrator
        Route::group([
            'prefix' => 'auth',
        ], function () {
            // Account
            Route::group([
                'prefix' => 'accounts',
                'namespace' => 'Auth',
                'middleware' => ['role:administrator']
            ], function () {
                Route::get('/', 'AccountController@list')->name('backend.account');
                Route::put('/', 'AccountController@active')->name('backend.account.active');
                Route::put('update-role', 'AccountController@updateRoleAdmin')->name('backend.account.update.role');
                Route::put('update-permission', 'AccountController@updatePermissionAdmin')->name('backend.account.update.permission');
            });

            // Role
            Route::group([
                'prefix' => 'roles',
                'namespace' => 'Auth',
                'middleware' => ['role:administrator']
            ], function () {
                Route::get('/', 'RoleController@list')->name('backend.role');
                Route::post('/', 'RoleController@create')->name('backend.role.create');
                Route::put('add-permission', 'RoleController@addPermissionToRole')->name('backend.role.add.permission');
                Route::delete('/', 'RoleController@delete')->name('backend.role.delete');
            });

            // Permission
            Route::group([
                'prefix' => 'permissions',
                'namespace' => 'Auth',
                'middleware' => ['role:administrator']
            ], function () {
                Route::get('/', 'PermissionController@list')->name('backend.permission');
                Route::post('/', 'PermissionController@create')->name('backend.permission.create');
            });

            // Profile
            Route::group([
                'prefix' => 'profile',
                'namespace' => 'Admins'
            ], function () {
                Route::group([
                    'prefix' => '{admin}',
                    'where' => ['admin', '[0-9]+']
                ], function () {
                    Route::get('/', 'AdminController@profile')->name('backend.profile');
                    Route::put('update', 'AdminController@updateProfile')->name('backend.profile.update');
                    Route::put('image', 'AdminController@image')->name('backend.update.profile.image');
                });

            });
        });


        // Post
        Route::group([
            'prefix' => 'post',
            'namespace' => 'Posts',
            'middleware' => ['role:administrator|manager|editor']
        ], function () {

            Route::get('/', 'PostController@list')->name('backend.post');
            Route::put('/category', 'PostController@UpdatePostCategory')->name('backend.post.category');
            Route::put('/tag', 'PostController@UpdatePostTag')->name('backend.post.tag');
            Route::delete('/delete', 'PostController@delete')->name('backend.post.delete');

            Route::get('/create', 'PostController@form')->name('backend.post.form');
            Route::post('/create', 'PostController@create')->name('backend.post.create');

        });

        // Category
        Route::group([
            'prefix' => 'category',
            'namespace' => 'Categories'
        ], function () {

            Route::get('/', 'CategoryController@list')->name('backend.category');
            Route::post('/create', 'CategoryController@createOrupdate')->name('backend.category.create');
            Route::delete('/delete', 'CategoryController@delete')->name('backend.category.delete');

        });

        // Tag
        Route::group([
            'prefix' => 'tag',
            'namespace' => 'Tags'
        ], function () {

            Route::get('/', 'TagController@list')->name('backend.tag');
            Route::post('/create', 'TagController@createOrupdate')->name('backend.tag.create');
            Route::delete('/delete', 'TagController@delete')->name('backend.tag.delete');

        });

        // code
        Route::group([
            'prefix' => 'code',
            'namespace' => 'Code',
            'middleware' => ['role:administrator']
        ], function () {
            Route::get('/transaction', 'CodeController@transaction')->name('backend.code.transaction');
            Route::get('/codesended', 'CodeController@codesended')->name('backend.code.codesended');
            Route::get('/codepurchase', 'CodeController@codepurchase')->name('backend.code.getcodepurchase');
            Route::post('/recalled', 'CodeController@recalled')->name('backend.code.recalled');
            Route::get('/viewImport', 'CodeController@viewImport')->name('backend.code.viewImport');
            Route::post('/import', 'CodeController@import')->name('backend.code.import');

        });

        // users
        Route::group([
            'prefix' => 'user',
            'namespace' => 'Users',
            'middleware' => ['role:administrator']
        ], function () {
            Route::get('/usersubscribe', 'UserController@usersubscribe')->name('backend.user.usersubscribe');
        });


        // Social
        Route::group([
            'prefix' => 'social',
            'namespace' => 'Socials',
            'middleware' => ['role:administrator|manager']
        ], function () {


            // Release
            Route::group([
                'prefix' => 'release',
            ], function () {
                Route::get('/', 'PostController@release')->name('backend.social.release');
                Route::put('/sale', 'PostController@sale')->name('backend.social.release.sale');
                Route::put('/', 'PostController@changePost')->name('backend.social.release.update');
            });

            // Comment
            Route::group([
                'prefix' => 'comment',
            ], function () {
                Route::get('/', 'CommentController@index')->name('backend.social.comment');
                Route::post('/', 'CommentController@create')->name('backend.social.comment.create');
                Route::put('/', 'CommentController@update')->name('backend.social.comment.update');
                Route::delete('/', 'CommentController@delete')->name('backend.social.comment.delete');
            });


            // Post
            Route::group([
                'prefix' => 'post',
            ], function () {
                Route::get('/', 'PostController@index')->name('backend.social.post');
                Route::post('/createOrUpdate', 'PostCOntroller@createOrUpdate')->name('backend.social.post.createOrupdate');
                Route::get('/detail/{post}', 'PostCOntroller@detail')->name('backend.social.post.detail');
                Route::delete('/', 'PostCOntroller@delete')->name('backend.social.post.delete');
            });



            // Account
            Route::group([
                'prefix' => 'accounts'
            ], function () {
                Route::get('/', 'AccountController@index')->name('backend.social.account');
                Route::post('/', 'AccountController@create')->name('backend.social.account.create');
                Route::delete('/', 'AccountController@delete')->name('backend.social.account.delete');
            });

            // JLPT
            Route::group([
                'prefix' => 'jlpt'
            ], function () {
                Route::get('/', 'JlptController@index')->name('backend.social.jlpt.index');
                Route::get('/create', 'JlptController@create')->name('backend.social.jlpt.create');
                Route::post('/store', 'JlptController@createOrUpdate')->name('backend.social.jlpt.store');
                Route::delete('/delete', 'JlptController@delete')->name('backend.social.jlpt.delete');
            });
        });


        // Job
        Route::group([
            'prefix' => 'job',
            'namespace' => 'Jobs',
            'middleware' => ['role:administrator']
        ], function () {
            Route::get('/', 'JobController@index')->name('backend.job.index');
            Route::get('/detail/{job}', 'JobController@detail')->name('backend.job.detail');
            Route::get('/active', 'JobController@active')->name('backend.job.active');
            Route::delete('/delete', 'JobController@delete')->name('backend.job.delete');
            Route::post('/activeAll', 'JobController@activeAll')->name('backend.job.activeAll');
        });




    });
});


Route::get('test',function (){
    return 'abc';
})->name('test');

//routes for ckeditor
Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');
Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');
