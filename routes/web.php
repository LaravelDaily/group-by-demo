<?php

use App\Http\Controllers\GroupByAggregateController;
use App\Http\Controllers\GroupByAggregateFunctionsController;
use App\Http\Controllers\GroupByAggregateWithCalculationsController;
use App\Http\Controllers\GroupByAndOrderRelatedColumnControllerWithEloquent;
use App\Http\Controllers\GroupByController;
use App\Http\Controllers\GroupByMultipleColumnsBuilder;
use App\Http\Controllers\GroupByMultipleColumnsEloquent;
use App\Http\Controllers\GroupByMultipleColumnsErrorEloquent;
use App\Http\Controllers\GroupByRawDayWithEloquent;
use App\Http\Controllers\GroupByRawMonthWithEloquent;
use App\Http\Controllers\GroupByRelatedColumnController;
use App\Http\Controllers\GroupByRelatedColumnControllerWithEloquent;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return to_route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('group-by', GroupByController::class)->name('group-by');
Route::get('group-by-aggregate', GroupByAggregateController::class)->name('group-by-aggregate');
Route::get('group-by-aggregate-functions', GroupByAggregateFunctionsController::class)->name('group-by-aggregate-functions');
Route::get('group-by-aggregate-calculations', GroupByAggregateWithCalculationsController::class)->name('group-by-aggregate-with-calculations');
Route::get('group-by-related-column', GroupByRelatedColumnController::class)->name('group-by-related-column');
Route::get('group-by-related-column-eloquent', GroupByRelatedColumnControllerWithEloquent::class)->name('group-by-related-column-eloquent');
Route::get('group-by-and-order-related-column-eloquent', GroupByAndOrderRelatedColumnControllerWithEloquent::class)->name('group-by-and-order-related-column-eloquent');
Route::get('group-by-raw-day-with-eloquent', GroupByRawDayWithEloquent::class)->name('group-by-raw-day-with-eloquent');
Route::get('group-by-raw-month-with-eloquent', GroupByRawMonthWithEloquent::class)->name('group-by-raw-month-with-eloquent');
Route::get('group-by-multiple-columns', GroupByMultipleColumnsEloquent::class)->name('group-by-multiple-columns-eloquent');
Route::get('group-by-multiple-columns-builder', GroupByMultipleColumnsBuilder::class)->name('group-by-multiple-columns-builder');
Route::get('group-by-multiple-columns-error', GroupByMultipleColumnsErrorEloquent::class)->name('group-by-multiple-columns-error');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
