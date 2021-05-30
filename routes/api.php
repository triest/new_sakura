<?php


use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AnketController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeCarouselController;
use App\Http\Controllers\PresentController;
use App\Http\Controllers\SearchController;

Route::middleware('api_token')->group(
        function () {
//    Route::post('new_purchases', 'Api\PurchaseController@newPurchases');
//    Route::post('update_children', 'Api\ChildrenController@updateChildren');
            //   Route::POST('emit', 'Api\UpdateAction@emit');
        }
);

Route::get('getalldataforsidepanel',[HomeController::class,'getAllDataForSidePanel']);
Route::get('visits', [AnketController::class,'apiVisits'])->middleware('auth')->name('visits');


Route::prefix('anket/search')->name('search.')->group(
        function () {
            Route::get('/', [SearchController::class,'search'])->name('main');
            Route::post('/savesettings', [SearchController::class,'saveSettings'])->name('main');
            Route::get('/getsettings',  [SearchController::class,'getSettings'])->name('main');
        }
);

Route::prefix('anket')->name('anket.')->group(
        function () {
            Route::get('{anketid}/album/{id}/', [AlbumController::class,'apiAlbumItem'])->name('main');
            Route::get('{anketid}/album/{id}/owner', [AlbumController::class,'apiAlbumOwner'])->name('main');
            Route::post('{id}/albums/{albumid}/upload/image',[AlbumController::class,'uploadPhoto']);
            Route::delete('{id}/albums/{albumid}/delete/{photoid}', [AlbumController::class,'deletePhoto']);
        }
);

//подарки
Route::prefix('presents')->name('present.')->group(
        function () {
            Route::get('/', [PresentController::class,'list'])->name('list');
            Route::post('/make',[PresentController::class,'make'])->name('make');
            Route::get('/get-anket-presents', [PresentController::class,'getAnketPresents'])->name('getAnketPresents');
        }
);



Route::prefix('like-carousel')->name('like-carousel.')->group(
        function () {
            Route::get('/get-anket', [LikeCarouselController::class,'getAnket'])->name('getAnket');
            Route::post('/like', [LikeCarouselController::class,'newLike']);
            Route::get('/check-like', [LikeCarouselController::class,'checkLike']);
        }
);

Route::prefix('like')->name('like.')->group(
        function () {
            Route::get('/get-like-list', [LikeCarouselController::class,'getLikesList'])->name('getLikesList');
        }
);

Route::prefix('contact')->middleware('auth')->name('contact.')->group(
        function () {
            Route::get('/', [ContactController::class,'index'])->name('main')->middleware('auth');
            Route::get('/contacts', [ContactController::class,'get']);
            Route::get('/conversation/{id}', [ContactController::class,'getMessagesFor']);
            Route::post('/conversation/send', [ContactController::class,'send']);
            Route::get('/count-unreaded', [ContactController::class,'countUnreaded']);
        }
);

Route::prefix('events')->name('events.')->group(
        function () {
            Route::get('/inmycity', [EventController::class,'inmycity'])->name('inmycity');
            Route::get('/check-request', [EventController::class,'check_request'])->name('check_request');
            Route::get('/make-request', [EventController::class,'makeRequest'])->name('make-request');
            Route::get('/accept', [EventController::class,'accept'])->name('accept');
            Route::get('/denied', [EventController::class,'denied']);
            Route::get('/{id}', [EventController::class,'view'])->name('view');
            Route::get('/request-list',  [EventController::class,'requestList']);
            Route::get('/request/unread', [EventController::class,'numberUnreadRequested'])->name('number');
            Route::get('/{id}/request-list', [EventController::class,'requestList'])->name('requestList');
        }
);

Route::prefix('likes')->middleware('auth')->name('likes.')->group(
    function () {
        Route::get('/', [LikeController::class,'index'])->name('index')->middleware('auth');
    }
);
