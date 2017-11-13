<?php

Route::prefix('streams')->middleware('client')->group(function () {

    Route::get('list', 'StreamsController@getStreamList');
    Route::get('viewer-count', 'StreamsController@getViewerCount');
});
