<?php

use Illuminate\Http\Request;

Route::middleware('api_token')->group(function () {
    Route::post('new_purchases', 'Api\PurchaseController@newPurchases');
    Route::post('update_children', 'Api\ChildrenController@updateChildren');
    Route::POST('emit', 'Api\UpdateAction@emit');
});
