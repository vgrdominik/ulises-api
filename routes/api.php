<?php
use Illuminate\Http\Request;
use App\Modules\User\Transformers\User as UserTransformer;

Route::middleware('auth:airlock')->get('/user', function (Request $request) {
    return new UserTransformer(auth()->user());
});

// Used to user authentication api

Route::namespace('\\App\\Modules\\User\\Infrastructure\\Controller\\')->group(function () {
    Route::post('/login', 'Api@login');
    // TODO Route::post('/refreshToken', 'Api@refreshToken');
    Route::middleware('auth:airlock')->post('/logout', 'Api@logout');
    Route::post('/forgotReset', 'Api@forgotReset');
    Route::post('/forgotSendResetLinkEmail', 'Api@forgotSendResetLinkEmail');
    Route::post('/register', 'Api@register');
    Route::post('/verify', 'Api@verify');
});

// Usual routes authed
Route::namespace('\\App\\Modules\\')->middleware('auth:airlock')->group(function () {
    Route::namespace('Event\\Infrastructure\\Controller')->group(function () {
        Route::get('eventSummary', 'Api@eventSummary');
        Route::resource('event', 'Api');
    });
    Route::namespace('Om\\Product\\Infrastructure\\Controller')->group(function () {
        Route::get('productSummary', 'Api@productSummary');
        Route::resource('product', 'Api');
        Route::get('complementSummary', 'ApiComplement@complementSummary');
        Route::resource('complement', 'ApiComplement');
        Route::get('complementTaxonSummary', 'ApiComplementTaxon@complementTaxonSummary');
        Route::resource('complementTaxon', 'ApiComplementTaxon');
    });
    Route::namespace('Om\\Channel\\Infrastructure\\Controller')->group(function () {
        Route::resource('channel', 'Api');
    });
    Route::namespace('Om\\Vendor\\Infrastructure\\Controller')->group(function () {
        Route::resource('vendor', 'Api');
    });
    Route::namespace('Om\\Taxon\\Infrastructure\\Controller')->group(function () {
        Route::resource('taxon', 'Api');
    });
});

// Public Om routes
Route::namespace('\\App\\Modules\\Om\\')->group(function () {
    // Nothing at the moment
});
