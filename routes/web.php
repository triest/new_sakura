<?php

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/lesson', 'HomeController@lesson')->name('lesson');

// Общий роутинг
//Route::redirect('/', '/lk');
    Route::prefix('anket')->name('anket.')->group(function () {
        Route::get('{id}', 'AnketController@view')->name('view');
        Route::get('/', 'AnketController@index')->name('main');
        Route::get('{id}/albums', 'AnketController@albums')->name('albums');
        Route::get('{id}/albums/{albumid}', 'AnketController@albumItem')->name('albumItem');
        Route::post('{id}/albums/upload/image', 'AnketController@uploadPhoto');
    });

    Route::prefix('contact')->name('anket.')->group(function () {
        Route::get('/', 'ContactController@index')->name('main')->middleware('auth');
        Route::get('/contacts', 'ContactController@get');
        Route::get('/conversation/{id}', 'ContactController@getMessagesFor');
        Route::post('/conversation/send', 'ContactController@send');
        Route::post('/conversation/sendModal', 'ContactController@sendModal');
    });

    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/inmycity', 'EventController@inmycity')->name('inmycity');
        Route::get('/', 'EventController@index')->name('index'); //сщбытия в моём горроде
        Route::get('/my', 'EventController@my')->name('my'); //мои события
        Route::get('/create', 'EventController@create')->name('create')->middleware('auth');
        Route::post('/store', 'EventController@store')->name('store')->middleware('auth');

        Route::get('/check-requwest', 'EventController@check_requwest')->name('check-requwest');
        Route::get('/make-requwest', 'EventController@makeRequwest')->name('make-requwest');
        Route::get('/accept', 'EventController@accept')->name('accept');
        Route::get('/denided', 'EventController@denided')->name('requwestlist');
        Route::get('/{id}', 'EventController@view')->name('view');
        Route::get('/{id}/requwestlist', 'EventController@requwestlist')->name('requwestlist');

        //  Route::get('/singup/{id}', 'MyEventController@singup')->name('viewmyevent')->middleware('auth');
    });


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

    Route::prefix('like-carusel')->name('like-carusel.')->group(function () {
        Route::get('/', 'LikeCaruselConroller@index')->name('index');
        Route::get('/getAnket', 'LikeCaruselConroller@getAnket')->name('getAnket');
        Route::get('/newLike', 'LikeCaruselConroller@newLike');
    });

    //поиск
    Route::prefix('seach')->name('seach.')->group(function () {
        Route::get('/', 'SeachController@seach')->name('main');
        Route::post('/savesettings', 'SeachController@saveSettings')->name('main');
        Route::get('/getsettings', 'SeachController@getSettings')->name('main');
    });

    //подарки
    Route::prefix('presents')->name('seach.')->group(function () {
        Route::get('/', 'SeachController@seach')->name('main');
        Route::post('/savesettings', 'SeachController@saveSettings')->name('main');
        Route::get('/getsettings', 'SeachController@getSettings')->name('main');
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
                Route::resource('roles', 'RoleController')->only([
                        'index',
                        'create',
                        'store',
                        'edit',
                        'update',
                        'destroy'
                ]);

                Route::get('menu', 'MenuController@index')->name('menu');
            });

            // Справочники
            Route::prefix('enum')->name('enum.')->group(function () {

            });


        });
    });

    Route::prefix('test')->name('test.')->namespace('Test')->group(function () {


    });
