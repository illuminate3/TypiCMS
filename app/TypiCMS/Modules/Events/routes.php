<?php
Route::bind('events', function ($value, $route) {
    return TypiCMS\Modules\Events\Models\Event::where('id', $value)
        ->with('translations')
        ->firstOrFail();
});

if (! App::runningInConsole()) {
    Route::group(array('before' => 'auth.public|cache', 'after' => 'cache'), function () {
        $routes = app('TypiCMS.routes');
        foreach (Config::get('app.locales') as $lang) {
            $uri = (array_key_exists('events', $routes)) ? $routes['events'][$lang] : $lang.'/events' ;
            Route::get(
                $uri,
                array(
                    'as' => $lang.'.events',
                    'uses' => 'TypiCMS\Modules\Events\Controllers\PublicController@index'
                )
            );
            Route::get(
                $uri.'/{slug}',
                array(
                    'as' => $lang.'.events.slug',
                    'uses' => 'TypiCMS\Modules\Events\Controllers\PublicController@show'
                )
            );
        }
    });
}

Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
    Route::resource(
        'events',
        'TypiCMS\Modules\Events\Controllers\AdminController'
    );
});
