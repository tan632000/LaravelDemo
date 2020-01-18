<?php
use Illuminate\Support\Facades\Auth;
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
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('admin/dangnhap','UserController@getdangnhapAdmin');
Route::post('admin/dangnhap','UserController@postdangnhapAdmin');

view()->composer('[*]', function ($view) {
    $user = Auth::user();
    $view->with('user',$user);
});

Route::get('admin/logout', 'UserController@getdangxuatAdmin');

Route::group(['prefix'=>'admin'],function(){
    Route::group(['prefix'=>'theloai'],function(){
        Route::get('danhsach','MyController@getDanhSach');
        Route::get('them','MyController@getThem');
        Route::post('them','MyController@postThem');

        Route::get('sua/{id}','MyController@getSua');
        Route::post('sua/{id}', 'MyController@postSua');

        Route::get('xoa/{id}','MyController@getXoa');
        });
    Route::group(['prefix'=>'loaitin'],function(){
        Route::get('danhsach','LoaiTinController@getDanhSach');
        Route::get('them','LoaiTinController@getThem');
        Route::post('them','LoaiTinController@postThem');

        Route::get('sua/{id}','LoaiTinController@getSua');
        Route::post('sua/{id}', 'LoaiTinController@postSua');

        Route::get('xoa/{id}','LoaiTinController@getXoa');
    });
    Route::group(['prefix'=>'tintuc'],function(){
        Route::get('danhsach','NewsController@getDanhSach');

        Route::get('them','NewsController@getThem');
        Route::post('them','NewsController@postThem');

        Route::get('sua/{id}','NewsController@getSua');
        Route::post('sua/{id}','NewsController@postSua');

        Route::get('xoa/{id}', 'NewsController@getXoa');

    });
    Route::group(['prefix'=>'slide'],function(){
        Route::get('danhsach','SlideController@getDanhSach');

        Route::get('them','SlideController@getThem');
        Route::post('them','SlideController@postThem');

        Route::get('sua/{id}','SlideController@getSua');
        Route::post('sua/{id}','SlideController@postSua');

        Route::get('xoa/{id}', 'SlideController@getXoa');

    });
    Route::group(['prefix'=>'user'],function(){
        Route::get('danhsach','UserController@getDanhSach');

        Route::get('them','UserController@getThem');
        Route::post('them','UserController@postThem');

        Route::get('sua/{id}','UserController@getSua');
        Route::post('sua/{id}','UserController@postSua');

        Route::get('xoa/{id}', 'UserController@getXoa');

    });
    Route::group(['prefix' => 'ajax'], function () {
        Route::get('loaitin/{idTheLoai}','AjaxController@getLoaiTin');
    });
    Route::group(['prefix' => 'comment'], function () {
        Route::get('xoa/{id}/{idTinTuc}','CommentController@getXoa');
    });
});
