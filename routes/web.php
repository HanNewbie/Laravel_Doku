<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controller\Admin\CarController;
use App\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/admin')->middleware('auth')->group(function() { // Mengatur rute untuk admin dengan middleware auth
    Route::get('/', function () { // Mengatur rute untuk halaman dashboard admin
        return redirect('admin/dashboard'); // Menampilkan view admin.dashboard
    });
}); 

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('homepage');
Route::get('detail/{car:slug}', [\App\Http\Controllers\HomeController::class, 'detail'])->name('detail');
Route::get('contact', [\App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::post('contact', [\App\Http\Controllers\HomeController::class, 'contactStore'])->name('contact.store');

Route::get('bayar/{car:slug}', [\App\Http\Controllers\HomeController::class, 'bayar'])->name('bayar');
Route::post('bayar/{car:slug}', [\App\Http\Controllers\HomeController::class, 'bayarStore'])->name('bayars.store');

Route::post('/checkout', [HomeController::class, 'bayarStore']);
Route::get('/invoice/{orders_id}', [\App\Http\Controllers\HomeController::class, 'invoice'])->name('invoice');

Route::group(['middleware' => 'is_admin', 'prefix' => 'admin', 'as' => 'admin.'], function(){
    Route::get('dashboard',[App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
    
    Route::resource('cars', \App\Http\Controllers\Admin\CarController::class);
    Route::put('cars/update-image/{id}', [\App\Http\Controllers\Admin\CarController::class,'updateImage'])->name('cars.updateImage');  

    Route::get('messages',[\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
    Route::delete('messages/{message}',[\App\Http\Controllers\Admin\MessageController::class, 'destroy'])->name('messages.destroy');
    
    Route::get('bayar',[\App\Http\Controllers\Admin\BayarController::class, 'index'])->name('bayars.index');
    Route::delete('bayar/{bayar}',[\App\Http\Controllers\Admin\BayarController::class, 'destroys'])->name('bayars.destroys');


});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
