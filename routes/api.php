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
    Route::namespace('Ulises\\Product\\Infrastructure\\Controller')->group(function () {
        Route::resource('product', 'Api');
        Route::resource('complement', 'ApiComplement');
        Route::resource('complementTaxon', 'ApiComplementTaxon');
    });
    Route::namespace('Ulises\\Channel\\Infrastructure\\Controller')->group(function () {
        Route::resource('channel', 'Api');
    });
    Route::namespace('Ulises\\Vendor\\Infrastructure\\Controller')->group(function () {
        Route::resource('vendor', 'Api');
    });
    Route::namespace('Ulises\\Taxon\\Infrastructure\\Controller')->group(function () {
        Route::resource('taxon', 'Api');
    });
});

// Public Ulises routes
Route::namespace('\\App\\Modules\\')->group(function () {
    Route::namespace('Ulises\\Vendor\\Infrastructure\\Controller')->group(function () {
        Route::get('vendorSummary', 'Api@vendorSummary');
    });
    Route::namespace('Ulises\\Taxon\\Infrastructure\\Controller')->group(function () {
        Route::get('taxonSummary', 'Api@taxonSummary');
    });
    Route::namespace('Ulises\\Product\\Infrastructure\\Controller')->group(function () {
        Route::get('productSummary', 'Api@productSummary');
        Route::get('complementSummary', 'ApiComplement@complementSummary');
        Route::get('complementTaxonSummary', 'ApiComplementTaxon@complementTaxonSummary');
    });
});
