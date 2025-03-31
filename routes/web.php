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
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/signed-url/{filename}', function ($filename) {
  if (!Storage::disk('s3')->exists($filename)) {
      return response()->json(['error' => 'File not found'], 404);
  }

  // CloudFront 経由の署名付きURLを作成
  $cloudfrontUrl = env('AWS_CLOUDFRONT_URL') . '/' . $filename;

  return response()->json(['signed_url' => $cloudfrontUrl]);
});

//一般ユーザー
Route::group(['middleware' => ['auth', 'can:user-higher']], function () {
    Route::get('/home', 'MemoController@timeline')->name('home');
    Route::get('/search', 'HomeController@search')->name('search');
    Route::get('/content/{id}', 'HomeController@content')->name('content');
    Route::get('/userlist', 'FavoriteController@userlist')->name('userlist');
    Route::post('content/{id}/favorites', 'FavoriteController@store')->name('favorites');
    Route::post('content/{id}/unfavorites', 'FavoriteController@destroy')->name('unfavorites');
    Route::post('/users/{user}/follow', 'FollowUserController@follow')->name('follow');
    Route::post('/users/{user}/unfollow', 'FollowUserController@unfollow')->name('unfollow');
    }
);
  
  // 管理者以上
  Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
    Route::get('/newpost', 'AccountController@newpost')->name('newpost');
    Route::post('/store', 'AccountController@store')->name('store');
    Route::get('/edit/{id}', 'AccountController@edit')->name('edit');
    Route::post('/update/{id}', 'AccountController@update')->name('update');
    Route::post('/delete/{id}', 'AccountController@delete')->name('delete');
    Route::get('/userdetail/{id}', 'AccountController@userdetail')->name('userdetail');
    Route::post('/account/{id}', 'AccountController@account')->name('accout');
    Route::post('/accountdelete/{id}', 'AccountController@accountdelete')->name('accoutdelete');


  });
