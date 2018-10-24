<?php



Route::get('/', 'HomeController@index' )->name('home');





//user subscriber routes
Route::post('subscribe','SubscriberController@store')->name('subscribe.store');



//post detail routes
Route::get('post/{slug}','PostDetailController@details')->name('post.detail');



Route::group(['middleware'=>'auth'], function (){
    Route::post('favourite/{postId}/add', 'FavouriteController@add')->name('favourite.post');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
//
// routing  for admin
Route::group(['as'=>'admin.','prefix' => 'admin', 'namespace'=>'Admin' ,'middleware'=>['auth' ,'admin']], function() {
    //
    //  rouuting for  admin dashboard
    Route::get('dashboard', 'DasboardController@index')->name('dashboard');
    Route::resource('tag', 'TagController');
    Route::resource('category', 'CategoryController');
    Route::resource('post', 'PostController');

//    settinng
    Route::get('settings','SettingsController@index')->name('settings');
    Route::put('profile-update','SettingsController@profileUpdate')->name('profile.update');
    Route::put('password-update','SettingsController@passwordUpdate')->name('password.update');






    Route::get('pending/post', 'PostController@pending')->name('post.pending');
    Route::put('/post/{id}/approve', 'PostController@approval')->name('post.approve');

    Route::get('/subscribers','SubscriberController@index')->name('subscribe.index');
    Route::delete('/subscriber/{id}','SubscriberController@delete')->name('subscribe.delete');

});



// routing  for author
Route::group(['as'=>'author.','prefix' => 'author', 'namespace'=>'Author' ,'middleware'=>['auth','author']], function() {
    // rouuting for author dashboard
    Route::get('dashboard', 'DasboardController@index')->name('dashboard');
    Route::resource('post', 'PostController');



//    settinng
    Route::get('settings','SettingsController@index')->name('settings');
    Route::put('profile-update','SettingsController@profileUpdate')->name('profile.update');
    Route::put('password-update','SettingsController@passwordUpdate')->name('password.update');



});


