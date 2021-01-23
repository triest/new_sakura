<?php

use Illuminate\Http\Request;

Route::middleware('api_token')->group(
        function () {
//    Route::post('new_purchases', 'Api\PurchaseController@newPurchases');
//    Route::post('update_children', 'Api\ChildrenController@updateChildren');
            //   Route::POST('emit', 'Api\UpdateAction@emit');
        }
);


Route::prefix('anket/search')->name('seach.')->group(
        function () {
            Route::get('/', 'SeachController@seach')->name('main');
            Route::post('/savesettings', 'SeachController@saveSettings')->name('main');
            Route::get('/getsettings', 'SeachController@getSettings')->name('main');
        }
);

Route::prefix('anket')->name('anket.')->group(
        function () {
            Route::get('{anketid}/album/{id}/', 'AlbumController@apiAlbumItem')->name('main');
            Route::post('{id}/albums/{albumid}/upload/image', 'AlbumController@uploadPhoto');
            Route::delete('{id}/albums/{albumid}/delete/{photoid}', 'AlbumController@deletePhoto');
        }
);


Route::prefix('like-carousel')->name('like-carousel.')->group(
        function () {
            Route::get('/getAnket', 'LikeCarouselController@getAnket')->name('getAnket');
            Route::get('/newLike', 'LikeCarouselController@newLike');
            Route::get('/checkLike', 'LikeCarouselController@checkLike');
        }
);

Route::prefix('contact')->name('contact.')->group(
        function () {
            Route::get('/', 'ContactController@index')->name('main')->middleware('auth');
            Route::get('/contacts', 'ContactController@get');
            Route::get('/conversation/{id}', 'ContactController@getMessagesFor');
            Route::post('/conversation/send', 'ContactController@send');
            Route::post('/conversation/sendModal', 'ContactController@send');
        }
);
