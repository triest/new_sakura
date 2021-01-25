<?php

use Illuminate\Http\Request;

Route::middleware('api_token')->group(
        function () {
//    Route::post('new_purchases', 'Api\PurchaseController@newPurchases');
//    Route::post('update_children', 'Api\ChildrenController@updateChildren');
            //   Route::POST('emit', 'Api\UpdateAction@emit');
        }
);


Route::prefix('anket/search')->name('search.')->group(
        function () {
            Route::get('/', 'SearchController@search')->name('main');
            Route::post('/savesettings', 'SearchController@saveSettings')->name('main');
            Route::get('/getsettings', 'SearchController@getSettings')->name('main');
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

Route::prefix('like')->name('like.')->group(
        function () {
            Route::get('/get-my-likes', 'LikeController@getMyLikes')->name('getMyLikes');
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

Route::prefix('events')->name('events.')->group(
        function () {
            Route::get('/inmycity', 'EventController@inmycity')->name('inmycity');
            Route::get('/check-request', 'EventController@check_request')->name('check_request');
            Route::get('/make-request', 'EventController@makeRequest')->name('make-request');
            Route::get('/accept', 'EventController@accept')->name('accept');
            Route::get('/denied', 'EventController@denied');
            Route::get('/{id}', 'EventController@view')->name('view');
            Route::get('/{id}/requestList', 'EventController@requestList')->name('requestList');
            //  Route::get('/singup/{id}', 'MyEventController@singup')->name('viewmyevent')->middleware('auth');
        }
);
