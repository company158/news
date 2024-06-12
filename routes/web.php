<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return redirect()->route('news.index');
});

Auth::routes(
    [
        'register' => false,
        'login' => false,
        'verify' => false,
        'reset' => false
    ]
);

Route::resource('news', NewsController::class);
Route::get('hidden-news',  [NewsController::class, 'getHideNews'])->name('getHideNews');
