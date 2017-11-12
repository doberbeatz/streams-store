<?php

Route::prefix('streams')->group(function () {

    Route::get('list', 'StreamsController@getStreamList');
    Route::get('viewers-count', 'StreamsController@getViewersCount');
});
