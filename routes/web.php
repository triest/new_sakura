<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AnketController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeCarouselController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PresentController;


Route::get('/',[HomeController::class,'index'])->middleware('not_login')->name('index');

Auth::routes(['verify' => true]);


Route::prefix('anket')->name('anket.')->middleware('auth')->group(
        function () {
            Route::get('/', [AnketController::class,'index'])->name('main');
            Route::get('{id}', [AnketController::class,'view'])->name('view');
            Route::get('{id}/albums', [AlbumController::class,'albums'])->name('albums');
            Route::get('{id}/albums/{albumid}', [AlbumController::class,'albumItem'])->name('albumItem');
            Route::post('{id}/albums/{albumid}/upload/image', [AlbumController::class,'uploadPhoto'])->name("uploadPhoto");
        }
);
Route::get('/visits',  [AnketController::class,'visits'])->name('visits');

Route::prefix('contact')->name('contact.')->group(
        function () {
            Route::get('/', [ContactController::class,'index'])->name('main')->middleware('auth');
            }
);

Route::resource('event', EventController::class)->except('update')->middleware('auth'); //сщбытия в моём горроде
Route::post('event/update', [' EventController::class','update'])->name('events.update')->middleware('auth'); //сщбытия в моём горроде
Route::prefix('events')->middleware('auth')->middleware('auth')->name('events.')->group(
        function () {

            Route::get('/{id}/request-list',  [EventController::class,'requestList'])->name('requestList');
            Route::get('/my', [EventController::class,'myEventsList'])->name('index'); //мои события
            Route::get('/my/events-list', [EventController::class,'myEventsList'])->name('my'); //мои события
        }
);


Route::prefix('lk')->middleware('auth')->name('lk.')->namespace('Lk')->group(
    function () {
        Route::auth(['verify' => true]);
        Route::post('join', [RegisterController::class,'join'])->name('join');
        Route::resource('profile', 'ProfileController');
    }
);

Route::prefix('like-carousel')->middleware('auth')->name('like-carousel.')->group(
        function () {
            Route::get('/', [LikeCarouselController::class,'index'])->name('index');
        }
);

Route::prefix('likes')->middleware('auth')->name('likes.')->group(
        function () {
            Route::get('/', [LikeController::class,'index'])->name('index')->middleware('auth');
        }
);

//подарки
Route::prefix('presents')->name('present.')->group(
    function () {
        Route::get('/my', [PresentController::class,'my'])->name('my');
    }
);



Route::get('/city', 'HomeController@city');
Route::get('/test', 'HomeController@test');
Route::get('/age', 'HomeController@calculatAge');
