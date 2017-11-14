<?php

Route::get('games', 'GamesController@getList');

Route::prefix('streams')
//    ->middleware('ip:127.0.0.1,192.168.*')
    ->group(function () {

    Route::get('list', 'StreamsController@getStreamList');
    Route::get('viewer-count', 'StreamsController@getViewerCount');
});
