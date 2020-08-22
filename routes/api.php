<?php

use Illuminate\Http\Request;

Route::middleware('api_token')->group(function () {
    Route::post('new_purchases', 'Api\PurchaseController@newPurchases');
    Route::post('update_children', 'Api\ChildrenController@updateChildren');
    Route::POST('emit', 'Api\UpdateAction@emit');
});

    Route::prefix('seach')->name('seach.')->group(function () {
        Route::get('/', 'SeachController@seach')->name('main');
        Route::post('/savesettings', 'SeachController@saveSettings')->name('main');
        Route::get('/getsettings', 'SeachController@getSettings')->name('main');
    });