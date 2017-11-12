<?php

Route::prefix('streams')->group(function () {

    Route::get('list', 'StreamsController@getStreamList');
    Route::get('views-count', 'StreamsController@getViewsCount');
});
