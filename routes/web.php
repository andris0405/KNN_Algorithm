<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TestController;
use Facade\Ignition\Commands\TestCommand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::prefix('admin')->group(function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/product', ProductController::class);
    Route::post('/import_product', [ProductController::class, 'import_product'])->name('import.product');
    Route::get('/delete-product/{id}', [ProductController::class, 'delete_product']);

    Route::get('/predict', [ProductController::class, 'prediksi'])->name('predict');

    Route::resource('/test', TestController::class);
    Route::post('/import-test', [TestController::class, 'import'])->name('import.test');
    Route::get('/export-test', [TestController::class, 'export_test'])->name('export.test');
    Route::post('/test-predict', [TestController::class, 'test_predict'])->name('test.predict');
});
