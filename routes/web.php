<?php

Route::get(
        '/',
        function () {
            return redirect('/anket');
        }
)->name('main');
Route::get('/lesson', 'HomeController@lesson')->name('lesson');

Auth::routes(['verify' => true]);


// Общий роутинг
//Route::redirect('/', '/lk');
Route::prefix('anket')->name('anket.')->group(
        function () {
            Route::get('{id}', 'AnketController@view')->name('view');
            Route::get('/', 'AnketController@index')->name('main');
            Route::get('{id}/albums', 'AlbumController@albums')->name('albums');
            Route::get('{id}/albums/{albumid}', 'AlbumController@albumItem')->name('albumItem');
            Route::post('{id}/albums/{albumid}/upload/image', 'AlbumController@uploadPhoto')->name("uploadPhoto");
        }
);
//csrf
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
            Route::get('/', 'EventController@index')->name('index'); //сщбытия в моём горроде
            Route::get('/my', 'EventController@my')->name('my'); //мои события
            Route::get('/create', 'EventController@create')->name('create')->middleware('auth');
            Route::post('/store', 'EventController@store')->name('store')->middleware('auth');

            Route::get('/check-request', 'EventController@check_request')->name('check_request');
            Route::get('/make-request', 'EventController@makeRequest')->name('make-request');
            Route::get('/accept', 'EventController@accept')->name('accept');
            Route::get('/denied', 'EventController@denied');
            Route::get('/{id}', 'EventController@view')->name('view');
            Route::get('/{id}/requestList', 'EventController@requestList')->name('requestList');
            //  Route::get('/singup/{id}', 'MyEventController@singup')->name('viewmyevent')->middleware('auth');
        }
);


// Личный кабинет
Route::prefix('lk')->name('lk.')->namespace('Lk')->group(
        function () {
            Route::auth(['verify' => true]);
            Route::redirect('/', '/lk/home');
            Route::post('join', 'Auth\RegisterController@join')->name('join');
            // Только верифицированный пользователь зоны "lk"
            Route::middleware(['auth:lk' => 'verified'])->group(
                    function () {
                        // Главный экран
                        Route::get('home', 'HomeController@index')->name('home');
                        Route::get('profile', 'HomeController@profile')->name('profile');
                        Route::post('profile', 'HomeController@store_profile')->name('profileStore');

                        //post crop image

                        Route::post('crop', 'HomeController@store_crop')->name('storeCrop');

                        Route::get(
                                'crop',
                                function () {
                                    return view('test.video');
                                }
                        );
                    }
            );
        }
);

Route::prefix('like-carousel')->name('like-carousel.')->group(
        function () {
            Route::get('/', 'LikeCarouselController@index')->name('index');
        }
);

//поиск
Route::prefix('seach')->name('seach.')->group(
        function () {
            Route::get('/', 'SeachController@seach')->name('main');
            Route::post('/savesettings', 'SeachController@saveSettings')->name('main');
            Route::get('/getsettings', 'SeachController@getSettings')->name('main');
        }
);

//подарки
Route::prefix('presents')->name('present.')->group(
        function () {
            Route::get('/', 'PresentController@list')->name('list');
            Route::post('/savesettings', 'SeachController@saveSettings')->name('main');
            Route::get('/getsettings', 'SeachController@getSettings')->name('main');
            Route::post('/make', 'PresentController@make')->name('make');
            Route::get('/get-anket-presents', 'PresentController@getAnketPresents')->name('getAnketPresents');
        }
);

// Закрытая часть для сотрудников
/*
    Route::prefix('admin')->name('admin.')->middleware('admin')->namespace('Admin')->group(function () {
        Route::redirect('/', 'home')->name('home');
        Route::get('/', 'AdminUsersController@index');
        Route::prefix('presents')->name('presents.')->middleware('admin')->group(function () {
            Route::get('/', 'AdminUsersController@presentsMain')->name('main');
            Route::get('/list', 'AdminUsersController@presentsList')->name('list');
            Route::post('/list/store-present', 'AdminUsersController@storePresent')->name('storePresent');
        });
        Route::prefix('anket')->name('anket.')->middleware('admin')->group(function () {
            Route::get('/', 'AdminUsersController@presentsMain')->name('main');
        });
        Route::prefix('price')->name('price.')->middleware('admin')->group(function () {
            Route::get('/', 'AdminUsersController@presentsMain')->name('main');asphp artisan backpack:crud user

        });
    });
*/

Route::get('/city', 'HomeController@city');
Route::get('/test', 'HomeController@test');
Route::get('/age', 'HomeController@calculatAge');
