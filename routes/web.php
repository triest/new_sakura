<?php

Route::get('/', 'HomeController@index')->name('home');
Route::get('/lesson', 'HomeController@lesson')->name('lesson');

// Общий роутинг
//Route::redirect('/', '/lk');



// Личный кабинет
Route::prefix('lk')->name('lk.')->namespace('Lk')->group(function () {
    Route::auth(['verify' => true]);
    Route::redirect('/', '/lk/home');

    // Только верифицированный пользователь зоны "lk"
    Route::middleware(['auth:lk' => 'verified'])->group(function () {

        // Главный экран
        Route::get('home', 'HomeController@index')->name('home');
        Route::get('profile', 'HomeController@profile')->name('profile');
        Route::post('profile', 'HomeController@store_profile')->name('profileStore');

        //post crop image

        Route::post('crop', 'HomeController@store_crop')->name('storeCrop');

        Route::get('crop', function () {
            return view('test.video');
        });
    });
});

// Закрытая часть для сотрудников
Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {
    Route::auth(['verify' => true]);
    Route::redirect('/', '/admin/home');

    // Только пользователь из зоны "admin"
    Route::middleware(['auth:admin', 'permission'])->group(function () {

        // Рабочий стол
        Route::get('home', 'HomeController@index')->name('home');

        // Настройки системы
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::resource('admin_users', 'AdminUsersController')->only(['index', 'edit', 'update', 'destroy']);
            Route::resource('roles', 'RoleController')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

            Route::get('menu', 'MenuController@index')->name('menu');
        });

        // Справочники
        Route::prefix('enum')->name('enum.')->group(function () {

        });



    });
});

    Route::prefix('test')->name('test.')->namespace('Test')->group(function () {


    });
