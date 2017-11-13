<?php

Route::prefix('streams')->group(function () {

    Route::get('list', 'StreamsController@getStreamList');
    Route::get('viewer-count', 'StreamsController@getViewerCount');
});
